<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\PengumpulanTugas; // Pastikan pakai model ini
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    // Menampilkan detail tugas dan form upload
    public function show($id)
    {
        $tugas = Tugas::with('guruMapel.mapel', 'guruMapel.user')->findOrFail($id);
        
        // Cek apakah siswa ini sudah pernah mengumpulkan tugas
        // Menggunakan PengumpulanTugas dan siswa_id (sesuai database kamu)
        $jawaban = PengumpulanTugas::where('tugas_id', $id)
                            ->where('siswa_id', Auth::id())
                            ->first();

        return view('siswa.tugas.show', compact('tugas', 'jawaban'));
    }

    // Memproses file jawaban yang diupload siswa
    public function kumpulTugas(Request $request, $id)
    {
        $request->validate([
            'file_jawaban' => 'required|mimes:pdf,doc,docx,xls,xlsx,zip,rar,png,jpg,jpeg|max:5120',
            'catatan_siswa' => 'nullable|string'
        ], [
            'file_jawaban.required' => 'Anda harus memilih file tugas terlebih dahulu.',
            'file_jawaban.max' => 'Ukuran file maksimal 5 MB.'
        ]);

        $file = $request->file('file_jawaban');
        $nama_file = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        
        // Simpan ke folder public/uploads/tugas
        $file->move(public_path('uploads/tugas'), $nama_file);

        // Simpan atau Update data ke database
        // Pakai updateOrCreate supaya kalau siswa upload ulang (revisi), datanya tertimpa, bukan dobel
        PengumpulanTugas::updateOrCreate(
            [
                'siswa_id' => Auth::id(),
                'tugas_id' => $id
            ],
            [
                'file_jawaban' => $nama_file,
                'catatan_siswa' => $request->input('catatan_siswa')
            ]
        );

        return back()->with('success', 'Tugas berhasil diunggah dan dikirim ke guru!');
    }
}