{{-- BAGIAN KANAN: Tabel Daftar Pengumuman --}}
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengumuman</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="15%">Tanggal</th>
                        <th width="15%">Kelas</th>
                        <th>Detail Pengumuman</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumuman as $p)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>
                        {{-- Mengambil nama kelas dari relasi, kalau kosong tampilkan 'Umum' --}}
                        <td><span class="badge bg-info text-dark">{{ $p->kelas->nama_kelas ?? 'Umum' }}</span></td>
                        <td>
                            <strong>{{ $p->judul }}</strong><br>
                            <small class="text-muted">{{ $p->isi_pengumuman }}</small>
                        </td>
                        <td>
                            <form action="{{ route('pengumuman.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus pengumuman ini bray?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i>Belum ada pengumuman yang lu buat bray.</i>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>