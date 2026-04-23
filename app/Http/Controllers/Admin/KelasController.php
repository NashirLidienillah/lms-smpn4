<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller {
    public function index() {
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas'
        ], [
            'nama_kelas.unique' => 'Nama kelas ini sudah terdaftar'
        ]);
        Kelas::create(['nama_kelas' => $request->nama_kelas]);
        return redirect('/admin/kelas')->with('success', 'Data kelas berhasil ditambahkan');
    }

    public function destroy($id) {
        $kelas = KElas::findOrFail($id);
        $kelas->delete();
        return redirect('/admin/kelas')->with('success', 'Data kelas berhasil dihapus');
    }
}