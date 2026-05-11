<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuruMapel;
use App\Models\Rombel;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\JawabanUjian;

class RekapNilaiController extends Controller
{
    public function index($id)
    {
        $jadwal = GuruMapel::with(['kelas', 'mapel'])->findOrFail($id);
        $kelas_id = $jadwal->kelas_id;
        $rombels = Rombel::with('user')->where('kelas_id', $kelas_id)->get();
        $listTugas = Tugas::where('guru_mapel_id', $id)->get();
        $listUjian = Ujian::with('soals')->where('guru_mapel_id', $id)->get();
        $rekapSiswa = [];

        foreach ($rombels as $rombel) {
            $siswa = $rombel->user;
            
            // Data dasar siswa
            $data = [
                'nama' => $siswa->name,
                'nis'  => $siswa->nis ?? '-', // Kalau ada NIS
                'nilai_tugas' => [],
                'nilai_ujian' => []
            ];

            // buat Cari Nilai Tugas Esai Siswa ini
            foreach ($listTugas as $tugas) {
                $pengumpulan = \App\Models\PengumpulanTugas::where('tugas_id', $tugas->id)
                                    ->where('siswa_id', $siswa->id)
                                    ->first();
                
                // Kalau ada nilai tampilkan, kalau belum ngerjain kasih '-'
                $data['nilai_tugas'][$tugas->id] = $pengumpulan && $pengumpulan->nilai !== null ? $pengumpulan->nilai : '-';
            }

            // buat Cari Nilai Ujian CBT Siswa ini
            foreach ($listUjian as $ujian) {
                $sudahMengerjakan = JawabanUjian::where('ujian_id', $ujian->id)
                                                ->where('user_id', $siswa->id) 
                                                ->exists();

                if ($sudahMengerjakan) {
                    $totalSoal = $ujian->soals->count();
                    $jawabanBenar = JawabanUjian::where('ujian_id', $ujian->id)
                                                ->where('user_id', $siswa->id)
                                                ->where('is_benar', true)
                                                ->count();
                    
                    $skor = ($totalSoal > 0) ? round(($jawabanBenar / $totalSoal) * 100, 2) : 0;
                    $data['nilai_ujian'][$ujian->id] = $skor;
                } else {
                    $data['nilai_ujian'][$ujian->id] = '-'; // Belum Mengerjakan
                }
            }

            // Masukkan ke barisan tabel
            $rekapSiswa[] = $data;
        }

        return view('guru.rekap.index', compact('jadwal', 'listTugas', 'listUjian', 'rekapSiswa'));
    }
}