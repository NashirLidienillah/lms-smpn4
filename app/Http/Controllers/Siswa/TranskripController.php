<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Rombel;
use App\Models\GuruMapel;
use App\Models\TahunAkademik;

class TranskripController extends Controller
{
    public function transkrip(Request $request)
    {
        $userId = Auth::user()->id;

        // 1. Ambil Tahun Akademik Aktif
        $tahunAktif = TahunAkademik::where('status_aktif', 1)->first();
        
        // Ambil input filter dari request (bisa 'all', ID spesifik, atau default ke tahun aktif)
        $tahunAkademikId = $request->get('tahun_akademik_id', $tahunAktif ? $tahunAktif->id : 'all');

        // 2. Ambil Rombel Siswa berdasarkan filter tahun akademik
        $rombelQuery = Rombel::where('user_id', $userId);

        if ($tahunAkademikId !== 'all') {
            $rombelQuery->where('tahun_akademik_id', $tahunAkademikId);
        }

        $rombelSiswa = $rombelQuery->get();

        $transkrip = [];

        // 3. Jika siswa terdaftar di rombel pada periode yang dipilih
        if ($rombelSiswa->isNotEmpty()) {
            
            $kelasIds = $rombelSiswa->pluck('kelas_id')->unique()->toArray();
            $tahunIds = $rombelSiswa->pluck('tahun_akademik_id')->unique()->toArray();

            // Ambil GuruMapel yang mengajar di kelas-kelas & tahun-tahun tersebut
            $guruMapelQuery = GuruMapel::whereIn('kelas_id', $kelasIds);
            
            if ($tahunAkademikId !== 'all') {
                $guruMapelQuery->whereIn('tahun_akademik_id', $tahunIds);
            }

            $guruMapels = $guruMapelQuery
                ->with(['mapel', 'user', 'kelas', 'tahunAkademik'])
                ->orderBy('tahun_akademik_id', 'desc')
                ->get();

            foreach ($guruMapels as $gm) {
                // Ambil Rincian Seluruh Tugas Siswa pada GuruMapel ini
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

                // Ambil Rincian Seluruh Kuis & Ujian Siswa pada GuruMapel ini
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

                // Hitung Rata-rata Nilai
                $tugasAvg = $listTugas->avg('nilai') ?? 0;
                $ujianAvg = $listUjian->avg('nilai') ?? 0;

                $transkrip[] = [
                    'mapel' => $gm->mapel->nama_mapel ?? 'N/A',
                    'guru' => $gm->user->name ?? 'N/A',
                    'kelas' => $gm->kelas->nama_kelas ?? '-',
                    'tahun_ajaran' => ($gm->tahunAkademik->nama_tahun ?? '') . ' (' . ($gm->tahunAkademik->semester ?? '') . ')',
                    'rata_tugas' => round($tugasAvg, 2),
                    'rata_ujian' => round($ujianAvg, 2),
                    'total_akhir' => round(($tugasAvg + $ujianAvg) / 2, 2),
                    'detail_tugas' => $listTugas,
                    'detail_ujian' => $listUjian
                ];
            }
        }

        // Ambil daftar tahun akademik untuk dropdown filter siswa
        $daftarTahunAkademik = TahunAkademik::orderBy('nama_tahun', 'desc')->get();

        return view('siswa.transkrip.index', compact('transkrip', 'daftarTahunAkademik', 'tahunAkademikId'));
    }
}