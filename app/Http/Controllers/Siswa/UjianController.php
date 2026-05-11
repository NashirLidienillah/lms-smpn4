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
        $user_id = \Illuminate\Support\Facades\Auth::id();
    
        $hasil = \App\Models\HasilUjian::where('ujian_id', $id)
                                       ->where('siswa_id', $user_id)
                                       ->first();
        
        return view('siswa.ujian.show', compact('ujian', 'hasil'));
    }

    public function kerjakan($id)
    {
        $ujian = Ujian::with('soals')->findOrFail($id);

        $sudahMengerjakan = JawabanUjian::where('user_id', Auth::id())
                                        ->where('ujian_id', $id)
                                        ->exists();

        if ($sudahMengerjakan) {
            return redirect('/siswa/dashboard')->with('error', 'Anda sudah mengerjakan ujian ini sebelumnya.');
        }

        return view('siswa.ujian.kerjakan', compact('ujian'));
    }

    public function simpanJawaban(Request $request, $id)
    {
        $user_id = \Illuminate\Support\Facades\Auth::id();
        $jawabanSiswa = $request->input('jawaban'); 

        if (!$jawabanSiswa) {
            return back()->with('error', 'Anda belum memilih jawaban apapun!');
        }

        $jumlahBenar = 0;
        $totalSoal = \App\Models\Soal::where('ujian_id', $id)->count();

        foreach ($jawabanSiswa as $soal_id => $pilihan) {
            $soal = \App\Models\Soal::find($soal_id);
            
            $is_benar = (strtoupper($soal->kunci_jawaban) == strtoupper($pilihan));

            // Jika benar, tambah ke counter
            if ($is_benar) {
                $jumlahBenar++;
            }

            \App\Models\JawabanUjian::create([
                'user_id' => $user_id,
                'ujian_id' => $id,
                'soal_id' => $soal_id,
                'jawaban_terpilih' => $pilihan,
                'is_benar' => $is_benar
            ]);
        }

        $jumlahSalah = $totalSoal - $jumlahBenar;
        $nilai = ($totalSoal > 0) ? round(($jumlahBenar / $totalSoal) * 100, 2) : 0;

        HasilUjian::updateOrCreate(
            ['ujian_id' => $id, 'siswa_id' => $user_id], 
            [
                'jumlah_benar' => $jumlahBenar,
                'jumlah_salah' => $jumlahSalah,
                'nilai' => $nilai
            ]
        );

        return redirect('/siswa/ujian/' . $id . '/hasil');
    }

    public function hasil($id)
    {
        $ujian = Ujian::with('soals')->findOrFail($id);
        $user_id = \Illuminate\Support\Facades\Auth::id();
        $hasil = HasilUjian::where('ujian_id', $id)->where('siswa_id', $user_id)->first();

        // Cegah error jika user memaksa buka halaman hasil tapi belum mengerjakan
        if (!$hasil) {
            return redirect('/siswa/dashboard')->with('error', 'Anda belum mengerjakan ujian ini.');
        }

        $jawabanBenar = $hasil->jumlah_benar;
        $totalSoal = $hasil->jumlah_benar + $hasil->jumlah_salah;
        $nilai = $hasil->nilai;

        return view('siswa.ujian.hasil', compact('ujian', 'jawabanBenar', 'totalSoal', 'nilai'));
    }
}