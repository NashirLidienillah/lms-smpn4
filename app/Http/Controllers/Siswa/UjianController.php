<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\JawabanUjian;
use Illuminate\Support\Facades\Auth;

class UjianController extends Controller
{
    /**
     * Menampilkan halaman konfirmasi sebelum mulai ujian
     */
    public function show($id)
    {
        // Memanggil relasi 'soals' sesuai dengan fungsi di Model Ujian kamu
        $ujian = Ujian::with('soals')->findOrFail($id);
        
        return view('siswa.ujian.show', compact('ujian'));
    }

    /**
     * Menampilkan lembar ujian (soal-soal)
     */
    public function kerjakan($id)
    {
        $ujian = Ujian::with('soals')->findOrFail($id);

        // Cek apakah siswa sudah pernah mengerjakan ujian ini
        $sudahMengerjakan = JawabanUjian::where('user_id', Auth::id())
                                        ->where('ujian_id', $id)
                                        ->exists();

        if ($sudahMengerjakan) {
            return redirect('/siswa/dashboard')->with('error', 'Anda sudah mengerjakan ujian ini sebelumnya.');
        }

        return view('siswa.ujian.kerjakan', compact('ujian'));
    }

    /**
     * Menyimpan seluruh jawaban siswa dan menghitung skor
     */
    public function simpanJawaban(Request $request, $id)
{
    $user_id = \Illuminate\Support\Facades\Auth::id();
    $jawabanSiswa = $request->input('jawaban'); 

    if (!$jawabanSiswa) {
        return back()->with('error', 'Anda belum memilih jawaban apapun!');
    }

    foreach ($jawabanSiswa as $soal_id => $pilihan) {
        $soal = \App\Models\Soal::find($soal_id);
        
        // GANTI 'jawaban_benar' MENJADI 'kunci_jawaban'
        // Gunakan strtoupper untuk jaga-jaga jika ada perbedaan huruf besar/kecil
        $is_benar = (strtoupper($soal->kunci_jawaban) == strtoupper($pilihan));

        \App\Models\JawabanUjian::create([
            'user_id' => $user_id,
            'ujian_id' => $id,
            'soal_id' => $soal_id,
            'jawaban_terpilih' => $pilihan,
            'is_benar' => $is_benar
        ]);
    }

    return redirect('/siswa/ujian/' . $id . '/hasil');
}

    public function hasil($id)
{
    $ujian = Ujian::with('soals')->findOrFail($id);
    $user_id = \Illuminate\Support\Facades\Auth::id();

    // Ambil semua jawaban siswa untuk ujian ini
    $jawabanSiswa = JawabanUjian::where('user_id', $user_id)
                                ->where('ujian_id', $id)
                                ->get();

    // Hitung skor
    $totalSoal = $ujian->soals->count();
    $jawabanBenar = $jawabanSiswa->where('is_benar', true)->count();
    
    // Rumus nilai: (Benar / Total) * 100
    $nilai = ($totalSoal > 0) ? round(($jawabanBenar / $totalSoal) * 100, 2) : 0;

    return view('siswa.ujian.hasil', compact('ujian', 'jawabanBenar', 'totalSoal', 'nilai'));
}
}