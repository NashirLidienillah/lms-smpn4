<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\TahunAkademik;

class RombelController extends Controller
{
    // Menampilkan halaman Rombel
    public function index(Request $request) {
    $tahunAktif = TahunAkademik::aktif(); // Ambil saklar aktif
    if (!$tahunAktif) return redirect('/admin/tahun-akademik')->with('error', 'Aktifkan Tahun Akademik dulu!');

    $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();
    $selectedKelas = null;
    $siswaDiKelas = [];
    $siswaBelumAdaKelas = [];

    if ($request->has('kelas_id')) {
        $selectedKelas = Kelas::findOrFail($request->kelas_id);
        
        // Ambil dari tabel rombels yang filternya Tahun Aktif
        $siswaDiKelas = Rombel::with('user')
            ->where('kelas_id', $selectedKelas->id)
            ->where('tahun_akademik_id', $tahunAktif->id)
            ->get();
            
        // Siswa yang belum masuk rombel DI TAHUN AKTIF INI
        $siswaSudahAdaRombel = Rombel::where('tahun_akademik_id', $tahunAktif->id)->pluck('user_id');
        $siswaBelumAdaKelas = User::where('role', 'siswa')
            ->whereNotIn('id', $siswaSudahAdaRombel)
            ->get();
    }

    return view('admin.rombel.index', compact('kelas', 'selectedKelas', 'siswaDiKelas', 'siswaBelumAdaKelas', 'tahunAktif'));
}

    // Memasukkan siswa ke kelas
    public function addStudent(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id'
        ]);

        $tahunAktif = TahunAkademik::aktif();
        if (!$tahunAktif) {
            return back()->with('error', 'Tidak ada tahun akademik yang aktif!');
        }

        // Cek ganda: pastikan siswa belum ada di kelas manapun di tahun ini
        $exists = Rombel::where('user_id', $request->user_id)
                        ->where('tahun_akademik_id', $tahunAktif->id)
                        ->exists();

        if ($exists) {
            return back()->with('error', 'Siswa tersebut sudah didaftarkan ke kelas pada tahun ajaran ini!');
        }

        // Catat ke tabel Rombel (Riwayat)
        Rombel::create([
            'user_id' => $request->user_id,
            'kelas_id' => $request->kelas_id,
            'tahun_akademik_id' => $tahunAktif->id
        ]);

        // UPDATE JUGA TABEL USERS
        $user = User::findOrFail($request->user_id);
        $user->update([
            'kelas_id' => $request->kelas_id
        ]);

        return back()->with('success', $user->name . ' berhasil dimasukkan ke kelas!');
    }

    // Mengeluarkan siswa dari kelas
    public function removeStudent($id)
    {
        $rombel = Rombel::with('user')->findOrFail($id);
        $namaSiswa = $rombel->user->name;
        $userId = $rombel->user_id; 
        
        // Hapus dari riwayat Rombel
        $rombel->delete(); 

        // KOSONGKAN JUGA KELAS DI TABEL USERS (Biar sinkron)
        User::where('id', $userId)->update([
            'kelas_id' => null
        ]);

        return back()->with('success', $namaSiswa . ' berhasil dikeluarkan dari kelas!');
    }
}