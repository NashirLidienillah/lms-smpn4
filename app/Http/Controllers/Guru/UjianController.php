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
}