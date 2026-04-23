<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class TahunAkademikController extends Controller
{
    public function index()
    {
        $tahun = TahunAkademik::orderBy('id', 'desc')->get();
        return view('admin.tahun_akademik.index', compact('tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tahun' => 'required|string|max:20',
            'semester' => 'required|in:Ganjil,Genap'
        ]);

        TahunAkademik::create([
            'nama_tahun' => $request->nama_tahun,
            'semester' => $request->semester,
            'status_aktif' => false 
        ]);

        return back()->with('success', 'Tahun akademik berhasil ditambahkan!');
    }

    // untuk mengaktifkan Tahun Akademik
    public function setAktif($id)
    {
        TahunAkademik::query()->update(['status_aktif' => false]);
        $tahun = TahunAkademik::findOrFail($id);
        $tahun->update(['status_aktif' => true]);

        return back()->with('success', 'Tahun Akademik ' . $tahun->nama_tahun . ' Semester ' . $tahun->semester . ' berhasil diaktifkan!');
    }

    public function destroy($id)
    {
        $tahun = TahunAkademik::findOrFail($id);
        if ($tahun->status_aktif) {
            return back()->with('error', 'Tahun akademik yang sedang aktif tidak boleh dihapus!');
        }
        $tahun->delete();
        return back()->with('success', 'Tahun akademik berhasil dihapus!');
    }
}