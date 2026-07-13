@extends('layouts.guru')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kelola Pengumuman Kelas</h1>

    {{-- Alert Notifikasi kalau berhasil atau gagal --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- BAGIAN KIRI: Form Tambah Pengumuman --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Buat Pengumuman Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengumuman.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="fw-bold">Pilih Kelas</label>
                            <select name="kelas_id" class="form-control" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="fw-bold">Judul Pengumuman</label>
                            <input type="text" name="judul" class="form-control" required placeholder="Contoh: Info Ujian Susulan">
                        </div>
                        <div class="form-group mb-3">
                            <label class="fw-bold">Isi Pengumuman</label>
                            <textarea name="isi_pengumuman" class="form-control" rows="4" required placeholder="Tulis detail informasi di sini..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Terbitkan Pengumuman</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: Tabel Daftar Pengumuman --}}
        <div class="col-md-8">
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
        </div>
    </div>
</div>
@endsection