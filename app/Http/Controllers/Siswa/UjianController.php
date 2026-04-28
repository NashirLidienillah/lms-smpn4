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
        $user_id = Auth::id();
        $jawabanSiswa = $request->input('jawaban'); // Array dari radio button

        if (!$jawabanSiswa) {
            return back()->with('error', 'Anda belum memilih jawaban apapun!');
        }

        foreach ($jawabanSiswa as $soal_id => $pilihan) {
            $soal = Soal::find($soal_id);
            
            // Logika hitung benar/salah
            // Pastikan di tabel soals ada kolom 'jawaban_benar' (A, B, C, D, atau E)
            $is_benar = ($soal->jawaban_benar == $pilihan);

            JawabanUjian::create([
                'user_id' => $user_id,
                'ujian_id' => $id,
                'soal_id' => $soal_id,
                'jawaban_terpilih' => $pilihan,
                'is_benar' => $is_benar
            ]);
        }

        return redirect('/siswa/dashboard')->with('success', 'Ujian berhasil dikirim! Jawaban Anda telah tersimpan.');
    }
}