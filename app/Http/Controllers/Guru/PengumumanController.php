<?php

namespace App\Http\Controllers\Guru;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index() {
        $pengumuman = Pengumuman::with('kelas')
        ->where('guru_id', Auth::id())
        ->latest()
        ->get();

        $kelas = Kelas::all();
        return view('guru.pengumuman.index', compact('pengumuman', 'kelas'));
    }

    public function store(Request $request, $id) {
        $request->validate([
            'judul' => 'required',  
            'isi_pengumuman' => 'required'
        ]);

        Pengumuman::create ([
            'kelas_id' => $id,
            'guru_id' => Auth::id(),
            'judul' => $request->judul,
            'isi_pengumuman' => $request->isi_pengumuman,
        ]);
        return back()->with('success', 'Pengumuman berhasil diterbitkan');
    }

    public function destroy($id) {
        $pengumuman = Pengumuman::findOrFail($id);
        if ($pengumuman->guru_id == Auth::id()) {
            $pengumuman->delete();
            return back()->with('success', 'Pengumuman berhasil dihapus bray!');
        }
        return back()->with('error', 'Anda tidak punya akses hapus pengumuman ini');
    }
}
