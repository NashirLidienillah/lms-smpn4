<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuruMapel;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Ujian;
use App\Models\LogPresensiMateri;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function show($id)
    {
        $userId = Auth::id();

        // Tarik data jadwal/kelas ini
        $jadwal = GuruMapel::with(['mapel', 'user', 'kelas'])->findOrFail($id);

        // Tarik semua konten yang berhubungan dengan kelas ini
        $materis = Materi::where('guru_mapel_id', $id)->latest()->get();

        // Cek status presensi siswa untuk setiap materi di kelas ini
        foreach ($materis as $materi) {
            $log = LogPresensiMateri::where('materi_id', $materi->id)
                ->where('siswa_id', $userId)
                ->first();

            $materi->sudah_presensi = $log ? true : false;
            $materi->waktu_presensi = $log ? $log->waktu_akses : null;
        }

        $tugass = Tugas::where('guru_mapel_id', $id)->latest()->get();
        $ujians = Ujian::with('soals')->where('guru_mapel_id', $id)->where('is_published', 1)->latest()->get();
        $pengumumans = \App\Models\Pengumuman::where('kelas_id', $jadwal->kelas_id)
                                ->latest()
                                ->get();

        return view('siswa.kelas.show', compact('jadwal', 'materis', 'tugass', 'ujians', 'pengumumans'));
    }

    // Method baru: Mengunduh/mengakses materi sekaligus mencatat presensi siswa
    public function downloadMateri($id)
    {
        $materi = Materi::findOrFail($id);

        // 1. Catat Presensi Otomatis
        LogPresensiMateri::firstOrCreate(
            [
                'materi_id' => $materi->id,
                'siswa_id'  => Auth::id()
            ],
            [
                'waktu_akses' => now()
            ]
        );

        // 2. Akses File atau Link Youtube
        if ($materi->tipe === 'file' && $materi->file_path) {
            $path = storage_path('app/public/materi/' . $materi->file_path);
            if (file_exists($path)) {
                return response()->download($path);
            }
            return back()->with('error', 'File materi tidak ditemukan.');
        } elseif ($materi->tipe === 'youtube') {
            return redirect()->away($materi->url_youtube);
        }

        return back()->with('error', 'Materi tidak dapat diakses.');
    }
}