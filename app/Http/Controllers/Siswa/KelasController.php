<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuruMapel;
use App\Models\Materi;
use App\Models\Tugas;
use App\Models\Ujian;

class KelasController extends Controller
{
    public function show($id)
    {
        // Tarik data jadwal/kelas ini
        $jadwal = GuruMapel::with(['mapel', 'user', 'kelas'])->findOrFail($id);

        // Tarik semua konten yang berhubungan dengan kelas ini
        $materis = Materi::where('guru_mapel_id', $id)->latest()->get();
        $tugass = Tugas::where('guru_mapel_id', $id)->latest()->get();
        $ujians = Ujian::with('soals')->where('guru_mapel_id', $id)->where('is_published', 1)->latest()->get();

        return view('siswa.kelas.show', compact('jadwal', 'materis', 'tugass', 'ujians'));
    }
}