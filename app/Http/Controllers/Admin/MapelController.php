<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = Mapel::orderBy('nama_mapel', 'asc')->get();
        return view('admin.mapel.index', compact('mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:100|unique:mapels,nama_mapel'
        ], [
            'nama_mapel.unique' => 'Mata pelajaran ini sudah terdaftar!'
        ]);

        Mapel::create(['nama_mapel' => $request->nama_mapel]);
        return redirect('/admin/mapel')->with('success', 'Mata Pelajaran berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->delete();
        return redirect('/admin/mapel')->with('success', 'Mata Pelajaran berhasil dihapus!');
    }
}