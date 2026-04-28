<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\TugasSiswa;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    // Menampilkan detail tugas dan form upload
    public function show($id)
    {
        $tugas = Tugas::with('guruMapel.mapel', 'guruMapel.user')->findOrFail($id);
        
        // Cek apakah siswa ini sudah pernah mengumpulkan tugas ini sebelumnya
        $jawaban = TugasSiswa::where('tugas_id', $id)
                            ->where('user_id', Auth::id())
                            ->first();

        return view('siswa.tugas.show', compact('tugas', 'jawaban'));
    }

    // Memproses file jawaban yang diupload siswa
    public function submit(Request $request, $id)
    {
        $request->validate([
            // Wajib upload file, maksimal 5MB, format bebas tapi umumnya ini:
            'file_jawaban' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,zip,rar|max:5120',
            'catatan_siswa' => 'nullable|string'
        ]);

        // Proses simpan file
        $file = $request->file('file_jawaban');
        // Bikin nama file unik: Timestamp_NamaSiswa_NamaAsliFile
        $nama_file = time() . '_' . str_replace(' ', '', Auth::user()->name) . '_' . $file->getClientOriginalName();
        // Simpan ke folder storage/app/public/jawaban_tugas
        $file->storeAs('public/jawaban_tugas', $nama_file);

        // Simpan data ke database
        TugasSiswa::create([
            'tugas_id' => $id,
            'user_id' => Auth::id(),
            'file_jawaban' => $nama_file,
            'catatan_siswa' => $request->catatan_siswa
        ]);

        return back()->with('success', 'Hore! Tugas berhasil dikumpulkan!');
    }
}