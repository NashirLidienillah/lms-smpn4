<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;

class UjianController extends Controller
{
    // Menyimpan pengaturan Ujian Baru
    public function store(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'durasi' => 'required|integer|min:5', // Minimal 5 menit
            'mulai' => 'required|date',
            'selesai' => 'required|date|after:mulai', // Selesai harus setelah waktu mulai
        ]);

        Ujian::create([
            'guru_mapel_id' => $id,
            'judul' => $request->judul,
            'durasi' => $request->durasi,
            'mulai' => $request->mulai,
            'selesai' => $request->selesai,
        ]);

        return back()->with('success', 'Ruang Ujian CBT berhasil dibuat! Silakan tambahkan soal.');
    }

    public function show($id) {
        $ujian = \App\Models\Ujian::with('soals')->findOrFail($id);
        return view('guru.ujian.show', compact('ujian'));
    }

    public function edit($id)
    {
        $ujian = Ujian::findOrFail($id);
        return view('guru.ujian.edit', compact('ujian'));
    }

    public function update(Request $request, $id)
    {
        $ujian = Ujian::findOrFail($id);
        
        $ujian->update([
            'judul' => $request->judul,
            'durasi' => $request->durasi,
            'mulai' => $request->mulai,
            'selesai' => $request->selesai,
        ]);

        return redirect('/guru/kelas/' . $ujian->guru_mapel_id)->with('success', 'Sesi Ujian berhasil diperbarui!');
    }

    // Menghapus Ujian
    public function destroy($id)
    {
        Ujian::findOrFail($id)->delete();
        return back()->with('success', 'Ujian beserta semua soalnya berhasil dihapus!');
    }

    public function rekapNilai($id)
    {
        $ujian = \App\Models\Ujian::with('soals')->findOrFail($id);
        // Ambil semua jawaban siswa yang sudah mengerjakan ujian ini
        $rekap = \App\Models\JawabanUjian::with('user')
                    ->where('ujian_id', $id)
                    ->get()
                    ->groupBy('user_id');

        return view('guru.ujian.rekap', compact('ujian', 'rekap'));
    }

    public function togglePublish($id)
    {
        $ujian = \App\Models\Ujian::findOrFail($id);
        
        // Validasi: Jangan izinkan publish kalau soal masih 0
        if (!$ujian->is_published && $ujian->soals()->count() == 0) {
            return back()->withErrors(['Tidak bisa membagikan Ujian. Silakan buat minimal 1 pertanyaan terlebih dahulu!']);
        }

        // Balikkan statusnya (kalau 0 jadi 1, kalau 1 jadi 0)
        $ujian->update(['is_published' => !$ujian->is_published]);

        $pesan = $ujian->is_published ? 'Ujian CBT berhasil dibagikan ke siswa!' : 'Ujian CBT ditarik kembali ke Draft.';
        return back()->with('success', $pesan);
    }
}