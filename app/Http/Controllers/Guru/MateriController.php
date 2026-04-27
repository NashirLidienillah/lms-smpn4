<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\GuruMapel;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;



class MateriController extends Controller
{
    // Menampilkan halaman Ruang Kelas & Daftar Materi
    public function show($id)
    {
        $jadwal = GuruMapel::with(['kelas', 'mapel'])
                    ->where('user_id', Auth::id())
                    ->findOrFail($id);

        $materis = Materi::where('guru_mapel_id', $id)->latest()->get();
        $tugas = \App\Models\Tugas::where('guru_mapel_id', $id)->latest()->get();
        $ujians = \App\Models\Ujian::where('guru_mapel_id', $id)->latest()->get();
        return view('guru.kelas.show', compact('jadwal', 'materis', 'tugas', 'ujians'));
    }

    // Menyimpan Materi Baru
    public function store(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:file,youtube',
            'file_materi' => 'required_if:tipe,file|file|mimes:pdf,doc,docx,ppt,pptx|max:5120', // Maksimal 5MB
            'url_youtube' => 'required_if:tipe,youtube|nullable|url'
        ], [
            'file_materi.max' => 'Ukuran file maksimal adalah 5MB.',
            'file_materi.mimes' => 'Format file harus berupa PDF, Word, atau PowerPoint.'
        ]);

        $materi = new Materi();
        $materi->guru_mapel_id = $id;
        $materi->judul = $request->judul;
        $materi->deskripsi = $request->deskripsi;
        $materi->tipe = $request->tipe;

        // Logika jika guru memilih upload FILE
        if ($request->tipe === 'file' && $request->hasFile('file_materi')) {
            $file = $request->file('file_materi');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            
            // Simpan file ke folder: storage/app/public/materi
            $path = $file->storeAs('materi', $filename, 'public');
            $materi->file_path = $filename;
        } 
        else if ($request->tipe === 'youtube') {
            $materi->url_youtube = $request->url_youtube;
        }

        $materi->save();

        return back()->with('success', 'Materi pembelajaran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        return view('guru.materi.edit', compact('materi'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);
        
        $materi->judul = $request->judul;
        $materi->deskripsi = $request->deskripsi;
        $materi->tipe = $request->tipe;

        // Cek jika tipe youtube
        if ($request->tipe == 'youtube') {
            $materi->url_youtube = $request->url_youtube;
        } 
        // Cek jika tipe file dan guru upload file baru
        elseif ($request->hasFile('file_materi')) {
            // Hapus file lama jika ada
            if ($materi->file_path && Storage::disk('public')->exists('materi/' . $materi->file_path)) {
                Storage::disk('public')->delete('materi/' . $materi->file_path);
            }
            $file = $request->file('file_materi');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->storeAs('materi', $filename, 'public');
            $materi->file_path = $filename;
            $materi->url_youtube = null; // Kosongkan URL youtube
        }

        $materi->save();
        return redirect('/guru/kelas/' . $materi->guru_mapel_id)->with('success', 'Materi berhasil diperbarui!');
    }

    // Menghapus Materi
    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        // Jika materi berupa file, hapus juga file fisiknya dari storage
        if ($materi->tipe === 'file' && $materi->file_path) {
            Storage::delete('public/materi/' . $materi->file_path);
        }

        $materi->delete();
        return back()->with('success', 'Materi berhasil dihapus!');
    }
}