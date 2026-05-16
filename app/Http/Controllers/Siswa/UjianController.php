<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\JawabanUjian;
use App\Models\HasilUjian; 
use Illuminate\Support\Facades\Auth;

class UjianController extends Controller
{
    public function show($id)
    {
        $ujian = Ujian::with('soals')->findOrFail($id);
        $user_id = Auth::id();
    
        $hasil = HasilUjian::where('ujian_id', $id)
                           ->where('siswa_id', $user_id)
                           ->first();
        
        return view('siswa.ujian.show', compact('ujian', 'hasil'));
    }

    public function kerjakan($id)
    {
        $ujian = Ujian::with('soals')->findOrFail($id);
        $user_id = Auth::id();

        // --- LOGIKA BARU PENJAGA PINTU UJIAN ---
        $hasil = HasilUjian::where('ujian_id', $id)->where('siswa_id', $user_id)->first();

        if ($hasil) {
            // Kalau statusnya sudah selesai, tendang ke dashboard
            if ($hasil->status === 'selesai') {
                return redirect('/siswa/dashboard')->with('error', 'Anda sudah menyelesaikan ujian ini.');
            }
            // Kalau statusnya diblokir, tendang ke dashboard
            if ($hasil->status === 'diblokir') {
                return redirect('/siswa/dashboard')->with('error', 'Akses Anda diblokir. Hubungi Guru Mata Pelajaran.');
            }
            // JIKA STATUSNYA 'mengerjakan', biarkan dia lewat (berarti aksesnya baru dibuka guru atau memang lagi ujian)
        } else {
            // Jika belum ada record HasilUjian sama sekali (baru pertama kali klik mulai)
            HasilUjian::create([
                'ujian_id' => $id, 
                'siswa_id' => $user_id,
                'jumlah_benar' => 0, 
                'jumlah_salah' => 0, 
                'nilai' => 0, 
                'status' => 'mengerjakan'
            ]);
        }

        return view('siswa.ujian.kerjakan', compact('ujian'));
    }

    public function simpanJawaban(Request $request, $id)
    {
        $user_id = Auth::id();
        $jawabanSiswa = $request->input('jawaban') ?? []; 
        
        // Cek apakah ini force submit dari Anti-Cheat
        $statusAkhir = $request->has('is_cheat') ? 'diblokir' : 'selesai';

        $jumlahBenar = 0;
        $totalSoal = Soal::where('ujian_id', $id)->count();

        if (!empty($jawabanSiswa)) {
            foreach ($jawabanSiswa as $soal_id => $pilihan) {
                $soal = Soal::find($soal_id);
                
                if($soal) {
                    $is_benar = (strtoupper($soal->kunci_jawaban) == strtoupper($pilihan));

                    if ($is_benar) {
                        $jumlahBenar++;
                    }

                    JawabanUjian::updateOrCreate(
                        ['user_id' => $user_id, 'ujian_id' => $id, 'soal_id' => $soal_id],
                        ['jawaban_terpilih' => $pilihan, 'is_benar' => $is_benar]
                    );
                }
            }
        }

        $jumlahSalah = $totalSoal - $jumlahBenar;
        $nilai = ($totalSoal > 0) ? round(($jumlahBenar / $totalSoal) * 100, 2) : 0;

        HasilUjian::updateOrCreate(
            ['ujian_id' => $id, 'siswa_id' => $user_id], 
            [
                'jumlah_benar' => $jumlahBenar,
                'jumlah_salah' => $jumlahSalah,
                'nilai' => $nilai,
                'status' => $statusAkhir
            ]
        );

        if ($statusAkhir === 'diblokir') {
            return redirect('/siswa/ujian/' . $id . '/hasil')->with('error', 'Ujian Anda dihentikan paksa karena terdeteksi melanggar aturan (Pindah Tab/Browser).');
        }

        return redirect('/siswa/ujian/' . $id . '/hasil')->with('success', 'Ujian berhasil diselesaikan!');
    }

    public function hasil($id)
    {
        $ujian = Ujian::with('soals')->findOrFail($id);
        $user_id = Auth::id();
        $hasil = HasilUjian::where('ujian_id', $id)->where('siswa_id', $user_id)->first();

        if (!$hasil) {
            return redirect('/siswa/dashboard')->with('error', 'Anda belum mengerjakan ujian ini.');
        }

        $jawabanBenar = $hasil->jumlah_benar;
        $totalSoal = $hasil->jumlah_benar + $hasil->jumlah_salah;
        $nilai = $hasil->nilai;

        return view('siswa.ujian.hasil', compact('ujian', 'jawabanBenar', 'totalSoal', 'nilai', 'hasil'));
    }
}