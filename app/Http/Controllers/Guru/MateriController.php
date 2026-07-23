<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\GuruMapel;
use App\Models\Materi;
use App\Models\Rombel;
use App\Models\User;
use App\Models\LogPresensiMateri;
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
        
        // Hitung total siswa di kelas ini untuk perbandingan rekap
        $siswaIds = Rombel::where('kelas_id', $jadwal->kelas_id)->pluck('user_id');
        $totalSiswa = User::whereIn('id', $siswaIds)->where('role', 'siswa')->count();

        // Tempelkan info berapa banyak siswa yang sudah baca di tiap card materi
        foreach ($materis as $m) {
            $m->total_dibaca = LogPresensiMateri::where('materi_id', $m->id)->count();
            $m->total_siswa = $totalSiswa;
        }

        $tugas = \App\Models\Tugas::where('guru_mapel_id', $id)->latest()->get();
        $ujians = \App\Models\Ujian::where('guru_mapel_id', $id)->latest()->get();
        $pengumumans = \App\Models\Pengumuman::where('kelas_id', $jadwal->kelas_id)->latest()->get();

        return view('guru.kelas.show', compact('jadwal', 'materis', 'tugas', 'ujians', 'pengumumans'));
    }

    // Method baru: Mengambil data JSON rekap siswa yang sudah / belum membaca materi (buat Modal/Popup Guru)
    public function rekapPresensi($materi_id)
    {
        $materi = Materi::with('guruMapel')->findOrFail($materi_id);
        $kelasId = $materi->guruMapel->kelas_id;

        $siswaIds = Rombel::where('kelas_id', $kelasId)->pluck('user_id');

        $rekap = User::whereIn('users.id', $siswaIds)
            ->where('role', 'siswa')
            ->leftJoin('log_presensi_materis', function ($join) use ($materi_id) {
                $join->on('users.id', '=', 'log_presensi_materis.siswa_id')
                     ->where('log_presensi_materis.materi_id', '=', $materi_id);
            })
            ->select(
                'users.id as user_id',
                'users.name as nama_siswa',
                'log_presensi_materis.waktu_akses'
            )
            ->orderBy('users.name', 'asc')
            ->get();

        return response()->json([
            'materi' => $materi->judul,
            'rekap' => $rekap
        ]);
    }

    // Menyimpan Materi Baru
    public function store(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:file,youtube',
            'file_materi' => 'required_if:tipe,file|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
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

        if ($request->tipe === 'file' && $request->hasFile('file_materi')) {
            $file = $request->file('file_materi');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->storeAs('materi', $filename, 'public');
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

        if ($request->tipe == 'youtube') {
            $materi->url_youtube = $request->url_youtube;
        } 
        elseif ($request->hasFile('file_materi')) {
            if ($materi->file_path && Storage::disk('public')->exists('materi/' . $materi->file_path)) {
                Storage::disk('public')->delete('materi/' . $materi->file_path);
            }
            $file = $request->file('file_materi');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->storeAs('materi', $filename, 'public');
            $materi->file_path = $filename;
            $materi->url_youtube = null;
        }

        $materi->save();
        return redirect('/guru/kelas/' . $materi->guru_mapel_id)->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        if ($materi->tipe === 'file' && $materi->file_path) {
            Storage::delete('public/materi/' . $materi->file_path);
        }

        $materi->delete();
        return back()->with('success', 'Materi berhasil dihapus!');
    }
}