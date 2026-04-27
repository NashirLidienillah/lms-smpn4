<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuruMapel;
use App\Models\TahunAkademik;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index() {
        $tahunAktif = TahunAkademik::aktif();
        $jadwalMengajar = [];

        if ($tahunAktif) {
            $jadwalMengajar = GuruMapel::with(['kelas', 'mapel'])
            ->where('user_id', Auth::id())
            ->where('tahun_akademik_id', $tahunAktif->id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();
        }
        return view('guru.dashboard', compact('tahunAktif', 'jadwalMengajar'));
    }
}