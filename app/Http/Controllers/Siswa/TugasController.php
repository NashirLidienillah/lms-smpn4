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
        // VALIDASI WAKTU
        $tugas = Tugas::findOrFail($id);
        if (\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($tugas->batas_waktu))) {
            return back()->with('error', 'Gagal memproses! Batas waktu pengumpulan tugas telah berakhir.');
        }

        // VALIDASI INPUT FILE
        $request->validate([
            'file_jawaban' => 'required|mimes:pdf,doc,docx,xls,xlsx,zip,rar,png,jpg,jpeg|max:5120',
            'catatan_siswa' => 'nullable|string'
        ], [
            'file_jawaban.required' => 'Anda harus memilih file tugas terlebih dahulu.',
            'file_jawaban.max' => 'Ukuran file maksimal 5 MB.'
        ]);

        // Cek apakah sudah ada jawaban sebelumnya
        $jawabanLama = PengumpulanTugas::where('tugas_id', $id)
                            ->where('siswa_id', Auth::id())
                            ->first();

        // JIKA SUDAH DINILAI, TOLAK UPLOAD ULANG
        if ($jawabanLama && $jawabanLama->nilai !== null) {
            return back()->with('error', 'Tugas sudah dinilai, kamu tidak bisa mengubah jawaban lagi.');
        }

        $file = $request->file('file_jawaban');
        $nama_file = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        
        $file->move(public_path('uploads/tugas'), $nama_file);

        // HAPUS FILE LAMA DARI SERVER
        if ($jawabanLama && $jawabanLama->file_jawaban) {
            $pathLama = public_path('uploads/tugas/' . $jawabanLama->file_jawaban);
            if (file_exists($pathLama)) {
                unlink($pathLama); // Menghapus file fisik
            }
        }

        // SIMPAN ATAU UPDATE KE DATABASE
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

        return back()->with('success', 'Tugas berhasil diperbarui dan dikirim ke guru!');
    }
}