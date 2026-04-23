<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuruMapel;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class GuruMapelController extends Controller
{
    public function index()
    {
        $tahunAktif = TahunAkademik::aktif();
        if (!$tahunAktif) return redirect('/admin/tahun-akademik')->with('error', 'Aktifkan Tahun Akademik dulu!');

        $guruMapels = GuruMapel::with(['user', 'mapel', 'kelas'])
                        ->where('tahun_akademik_id', $tahunAktif->id)
                        ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
                        ->orderBy('jam_mulai', 'asc')
                        ->get();
        
        $gurus = User::where('role', 'guru')->orderBy('name', 'asc')->get();
        $mapels = Mapel::orderBy('nama_mapel', 'asc')->get();
        $kelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        return view('admin.guru_mapel.index', compact('guruMapels', 'gurus', 'mapels', 'kelas', 'tahunAktif'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'mapel_id' => 'required',
            'kelas_id' => 'required',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ], [
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai!'
        ]);

        $tahunAktif = TahunAkademik::aktif();
        if (!$tahunAktif) return back()->with('error', 'Tidak ada tahun akademik yang aktif!');

        // 1. CEK BENTROK KELAS DI TAHUN YANG SAMA
        $bentrokKelas = GuruMapel::where('kelas_id', $request->kelas_id)
            ->where('tahun_akademik_id', $tahunAktif->id)
            ->where('hari', $request->hari)
            ->where('jam_mulai', '<', $request->jam_selesai)
            ->where('jam_selesai', '>', $request->jam_mulai)
            ->exists();

        if ($bentrokKelas) {
            return back()->with('error', 'Jadwal Bentrok! Kelas ini sudah memiliki jadwal di waktu tersebut.');
        }

        // 2. CEK BENTROK GURU DI TAHUN YANG SAMA
        $bentrokGuru = GuruMapel::where('user_id', $request->user_id)
            ->where('tahun_akademik_id', $tahunAktif->id)
            ->where('hari', $request->hari)
            ->where('jam_mulai', '<', $request->jam_selesai)
            ->where('jam_selesai', '>', $request->jam_mulai)
            ->exists();

        if ($bentrokGuru) {
            return back()->with('error', 'Jadwal Bentrok! Guru tersebut sudah mengajar di kelas lain pada waktu yang sama.');
        }

        // Simpan data dengan ID Tahun Akademik Aktif
        GuruMapel::create([
            'user_id' => $request->user_id,
            'mapel_id' => $request->mapel_id,
            'kelas_id' => $request->kelas_id,
            'tahun_akademik_id' => $tahunAktif->id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect('/admin/guru-mapel')->with('success', 'Jadwal pelajaran berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        GuruMapel::findOrFail($id)->delete();
        return redirect('/admin/guru-mapel')->with('success', 'Jadwal pelajaran berhasil dihapus!');
    }
}