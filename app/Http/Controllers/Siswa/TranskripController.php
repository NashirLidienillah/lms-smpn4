<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Rombel;
use App\Models\GuruMapel;

class TranskripController extends Controller
{
    public function transkrip()
    {
        $userId = Auth::user()->id;

        $rombel = Rombel::where('user_id', $userId)->first();

        if (!$rombel) {
            return redirect()->back()->with('error', 'Kamu belum terdaftar di kelas manapun.');
        }

        $guruMapels = GuruMapel::where('kelas_id', $rombel->kelas_id)
                    ->with(['mapel', 'user'])
                    ->get();

        $transkrip = [];

        foreach ($guruMapels as $gm) {
            // Ambil Rincian Seluruh Tugas
            $listTugas = DB::table('pengumpulan_tugas')
                ->join('tugas', 'pengumpulan_tugas.tugas_id', '=', 'tugas.id')
                ->where('pengumpulan_tugas.siswa_id', $userId) 
                ->where('tugas.guru_mapel_id', $gm->id)
                ->select(
                    'tugas.judul', 
                    'pengumpulan_tugas.nilai', 
                    'pengumpulan_tugas.created_at',
                    'pengumpulan_tugas.catatan_guru'
                )
                ->orderBy('tugas.created_at', 'desc')
                ->get();

            // Ambil Rincian Seluruh Kuis & Ujian
            $listUjian = DB::table('hasil_ujians')
                ->join('ujians', 'hasil_ujians.ujian_id', '=', 'ujians.id')
                ->where('hasil_ujians.siswa_id', $userId)
                ->where('ujians.guru_mapel_id', $gm->id)
                ->select(
                    'ujians.judul', 
                    'hasil_ujians.nilai', 
                    'hasil_ujians.updated_at'
                )
                ->orderBy('ujians.created_at', 'desc')
                ->get();

            // Hitung Rata-rata
            $tugasAvg = $listTugas->avg('nilai') ?? 0;
            $ujianAvg = $listUjian->avg('nilai') ?? 0;

            $transkrip[] = [
                'mapel' => $gm->mapel->nama_mapel ?? 'N/A',
                'guru' => $gm->user->name ?? 'N/A',
                'rata_tugas' => round($tugasAvg, 2),
                'rata_ujian' => round($ujianAvg, 2),
                'total_akhir' => round(($tugasAvg + $ujianAvg) / 2, 2),
                'detail_tugas' => $listTugas,
                'detail_ujian' => $listUjian
            ];
        }

        return view('siswa.transkrip.index', compact('transkrip'));
    }
}