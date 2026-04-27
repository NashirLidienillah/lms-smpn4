<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Soal;

class SoalController extends Controller
{
    // Menyimpan Soal Baru
    public function store(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'kunci_jawaban' => 'required|in:a,b,c,d',
        ]);

        Soal::create([
            'ujian_id' => $id,
            'pertanyaan' => $request->pertanyaan,
            'pilihan_a' => $request->pilihan_a,
            'pilihan_b' => $request->pilihan_b,
            'pilihan_c' => $request->pilihan_c,
            'pilihan_d' => $request->pilihan_d,
            'kunci_jawaban' => $request->kunci_jawaban,
        ]);

        return back()->with('success', 'Berhasil menambahkan soal baru!');
    }

    public function edit($id)
    {
        $soal = Soal::findOrFail($id);
        return view('guru.soal.edit', compact('soal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'kunci_jawaban' => 'required|in:a,b,c,d',
        ]);

        $soal = Soal::findOrFail($id);
        
        $soal->update([
            'pertanyaan' => $request->pertanyaan,
            'pilihan_a' => $request->pilihan_a,
            'pilihan_b' => $request->pilihan_b,
            'pilihan_c' => $request->pilihan_c,
            'pilihan_d' => $request->pilihan_d,
            'kunci_jawaban' => $request->kunci_jawaban,
        ]);

        return redirect('/guru/ujian/' . $soal->ujian_id)->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    // Menghapus Soal
    public function destroy($id)
    {
        Soal::findOrFail($id)->delete();
        return back()->with('success', 'Soal berhasil dihapus!');
    }
}