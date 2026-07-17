{{-- BAGIAN KIRI: Form Tambah Pengumuman --}}
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