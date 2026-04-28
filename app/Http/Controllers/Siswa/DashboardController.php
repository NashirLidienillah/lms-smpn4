<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuruMapel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index() {
        $kelas_id = Auth::user()->kelas_id;
        if (empty($kelas_id)) {
            // Jika belum punya kelas, kembalikan data kosong (tidak perlu query ke database)
            $jadwals = collect(); 
            return view('siswa.dashboard', compact('jadwals'));
        }
        // Jika sudah punya kelas (Misal: Kelas 7A, 8B, 9C), tarik jadwal HANYA untuk kelas tersebut
        $jadwals = \App\Models\GuruMapel::with(['mapel', 'user'])
                    ->where('kelas_id', $kelas_id)
                    ->get();

        return view('siswa.dashboard', compact('jadwals'));

    }
}