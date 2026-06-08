@extends('layouts.app')

@section('content')

{{-- ================= NOTIFIKASI TOAST (BENTO STYLE) ================= --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-2xl shadow-xl border-l-4 border-green-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

@if($errors->any())
    <div id="toast-error" class="fixed top-5 right-5 flex items-start w-full max-w-md p-5 mb-4 text-gray-700 bg-white rounded-2xl shadow-2xl border-l-4 border-red-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-red-500 bg-red-50 rounded-xl mt-0.5"><i class="fas fa-exclamation-circle text-xl"></i></div>
        <div class="ml-4 text-sm">
            <span class="font-bold text-red-600 block mb-1 text-base">Kesalahan Validasi Data</span>
            <ul class="list-disc pl-4 text-gray-500 space-y-1 text-xs font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="ml-auto text-gray-300 hover:text-gray-900 transition" onclick="document.getElementById('toast-error').remove()"><i class="fas fa-times"></i></button>
    </div>
@endif

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <a href="/guru/dashboard" class="group inline-flex items-center text-sm font-bold text-gray-400 hover:text-blue-600 transition">
        <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-blue-50 flex items-center justify-center mr-3 transition">
            <i class="fas fa-arrow-left text-xs"></i>
        </div>
        Kembali ke Beranda Guru
    </a>

    <a href="/guru/kelas/{{ $jadwal->id }}/rekap-nilai" class="w-full sm:w-auto bg-white border border-blue-200 text-blue-600 hover:bg-blue-600 hover:text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-sm transition flex items-center justify-center gap-2">
        <i class="fas fa-chart-bar"></i> Rekap Nilai Siswa
    </a>
</div>

<div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center relative overflow-hidden">
    <div class="absolute left-0 top-0 h-full w-2 bg-blue-600"></div>
    <div class="relative z-10">
        <div class="flex items-center gap-3 mb-2">
            <span class="bg-blue-50 text-blue-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-[0.1em] border border-blue-100">Kelola Ruang Kelas</span>
            <span class="text-gray-300">•</span>
            <span class="text-sm font-bold text-gray-400">Kelas {{ $jadwal->kelas->nama_kelas }}</span>
        </div>
        <h2 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight">{{ $jadwal->mapel->nama_mapel }}</h2>
    </div>
    
    <div class="mt-6 md:mt-0 bg-slate-50 p-5 rounded-2xl border border-slate-100 flex items-center gap-4 min-w-[200px]">
        <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-blue-600 text-xl">
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div>
            <span class="block text-[10px] text-gray-400 font-black uppercase tracking-wider">Jadwal Pelajaran</span>
            <span class="block text-gray-800 font-extrabold text-sm">{{ $jadwal->hari }}</span>
            <span class="block text-xs text-gray-500 font-medium">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB</span>
        </div>
    </div>
</div>

<div class="bg-gray-100/50 p-1.5 rounded-2xl flex flex-wrap gap-1 mb-8 shadow-inner border border-gray-200/50">
    <button onclick="gantiTab('materi')" id="btn-tab-materi" class="flex-1 min-w-[120px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2">
        <i class="fas fa-book-open"></i> Materi
    </button>
    <button onclick="gantiTab('tugas')" id="btn-tab-tugas" class="flex-1 min-w-[120px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2">
        <i class="fas fa-tasks"></i> Tugas Kelas
    </button>
    <button onclick="gantiTab('ujian')" id="btn-tab-ujian" class="flex-1 min-w-[120px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2">
        <i class="fas fa-vial"></i> Kuis & Ujian
    </button>
</div>

{{-- PANEL 1: MATERI --}}
<div id="konten-materi" class="grid grid-cols-1 lg:grid-cols-3 gap-8 transition-all">
    <div class="lg:col-span-2 space-y-4">
        @forelse($materis as $materi)
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex flex-col sm:flex-row justify-between items-start gap-4 hover:shadow-xl transition-all duration-300 group">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 transition-transform group-hover:scale-110 {{ $materi->tipe === 'file' ? 'bg-orange-50 text-orange-500' : 'bg-red-50 text-red-500' }}">
                        <i class="fas {{ $materi->tipe === 'file' ? 'fa-file-pdf' : 'fa-play-circle' }}"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-lg group-hover:text-blue-600 transition-colors">{{ $materi->judul }}</h4>
                        <p class="text-gray-400 text-xs leading-relaxed mt-1 mb-4">{{ $materi->deskripsi ?? 'Belum ada deskripsi tambahan.' }}</p>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest"><i class="far fa-clock mr-1"></i> {{ $materi->created_at->diffForHumans() }}</span>
                            @if($materi->tipe === 'file')
                                <a href="{{ asset('storage/materi/' . $materi->file_path) }}" target="_blank" class="text-[10px] font-black bg-orange-100 text-orange-600 px-4 py-2 rounded-lg uppercase tracking-wider hover:bg-orange-600 hover:text-white transition-all"><i class="fas fa-file-download mr-1"></i> Unduh Materi</a>
                            @else
                                <a href="{{ $materi->url_youtube }}" target="_blank" class="text-[10px] font-black bg-red-100 text-red-600 px-4 py-2 rounded-lg uppercase tracking-wider hover:bg-red-600 hover:text-white transition-all"><i class="fab fa-youtube mr-1"></i> Tautan Video</a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex sm:flex-col gap-2 w-full sm:w-auto">
                    <a href="/guru/materi/{{ $materi->id }}/edit" class="flex-1 sm:w-10 sm:h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center transition border border-gray-100"><i class="fas fa-pen text-sm"></i></a>
                    
                    <form id="form-hapus-materi-{{ $materi->id }}" action="/guru/materi/{{ $materi->id }}" method="POST" class="flex-1">
                        @csrf @method('DELETE') 
                        <button type="button" onclick="hapusDataAdminStyle('form-hapus-materi-{{ $materi->id }}', 'Materi: {{ $materi->judul }}')" class="w-full sm:w-10 sm:h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-600 flex items-center justify-center transition border border-gray-100"><i class="fas fa-trash-alt text-sm"></i></button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-16 text-center">
                <div class="w-20 h-20 bg-white text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-3xl"><i class="fas fa-folder-open"></i></div>
                <h4 class="font-bold text-gray-400">Belum ada materi pembelajaran tercatat.</h4>
            </div>
        @endforelse
    </div>
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
            <div class="bg-blue-600 px-6 py-5 flex items-center gap-3">
                <i class="fas fa-plus-circle text-white text-xl"></i>
                <h3 class="font-bold text-white uppercase tracking-wider text-sm">Tambah Materi</h3>
            </div>
            <form action="/guru/kelas/{{ $jadwal->id }}/materi" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Judul Materi</label>
                    <input type="text" name="judul" required placeholder="Contoh: Pertemuan 1 - Pengenalan Dasar" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase tracking-widest mb-2">Jenis Sumber</label>
                    <select name="tipe" id="tipe_materi" onchange="toggleTipeInput()" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700">
                        <option value="file">📄 Berkas Dokumen (PDF / Word)</option>
                        <option value="youtube">📺 Video Pembelajaran (YouTube)</option>
                    </select>
                </div>
                <div id="box_file" class="p-4 bg-orange-50/50 border border-orange-100 rounded-2xl">
                    <label class="block text-[10px] font-black text-orange-700 uppercase mb-2">Pilih File</label>
                    <input type="file" name="file_materi" class="w-full text-xs text-orange-600 font-medium">
                </div>
                <div id="box_youtube" class="p-4 bg-red-50/50 border border-red-100 rounded-2xl hidden">
                    <label class="block text-[10px] font-black text-red-700 uppercase mb-2">Link YouTube</label>
                    <input type="url" name="url_youtube" placeholder="https://youtube.com/..." class="w-full p-2.5 bg-white border border-red-200 rounded-xl text-xs">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-blue-100 transition-all active:scale-95 uppercase tracking-widest text-xs">Simpan Data Materi</button>
            </form>
        </div>
    </div>
</div>

{{-- PANEL 2: TUGAS KELAS --}}
<div id="konten-tugas" class="grid grid-cols-1 lg:grid-cols-3 gap-8 hidden transition-all">
    <div class="lg:col-span-2 space-y-4">
        @forelse($tugas as $t)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative group overflow-hidden">
                <div class="absolute left-0 top-0 h-full w-1.5 bg-purple-500 transition-all group-hover:w-3"></div>
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    <div class="flex gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl shrink-0"><i class="fas fa-file-signature"></i></div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-lg">{{ $t->judul }}</h4>
                            <div class="inline-flex items-center gap-1.5 text-red-600 text-[10px] font-black uppercase bg-red-50 px-2 py-1 rounded-md mb-3 mt-1">
                                <i class="fas fa-hourglass-half"></i> Batas Pengumpulan: {{ $t->batas_waktu->format('d M, H:i') }}
                            </div>
                            <p class="text-gray-400 text-sm leading-relaxed mb-4">{{ Str::limit($t->deskripsi, 120) }}</p>
                            <a href="/guru/tugas/{{ $t->id }}/koreksi" class="bg-purple-600 hover:bg-purple-700 text-white text-[10px] font-black px-5 py-3 rounded-xl uppercase tracking-widest shadow-lg shadow-purple-100 transition-all flex items-center justify-center w-full sm:w-max">
                                <i class="fas fa-user-edit mr-2"></i> Periksa Lembar Jawaban Siswa
                            </a>
                        </div>
                    </div>

                    <div class="flex sm:flex-col gap-2 shrink-0">
                        <a href="/guru/tugas/{{ $t->id }}/edit" class="w-10 h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-purple-50 hover:text-purple-600 flex items-center justify-center transition border border-gray-100"><i class="fas fa-pen text-sm"></i></a>
                        
                        <form id="form-hapus-tugas-{{ $t->id }}" action="/guru/tugas/{{ $t->id }}" method="POST">
                            @csrf @method('DELETE') 
                            <button type="button" onclick="hapusDataAdminStyle('form-hapus-tugas-{{ $t->id }}', 'Tugas: {{ $t->judul }}')" class="w-10 h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-600 flex items-center justify-center transition border border-gray-100"><i class="fas fa-trash-alt text-sm"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-16 text-center">
                <div class="w-20 h-20 bg-white text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-3xl"><i class="fas fa-tasks"></i></div>
                <h4 class="font-bold text-gray-400">Belum ada daftar tugas untuk kelas ini.</h4>
            </div>
        @endforelse
    </div>
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
            <div class="bg-purple-600 px-6 py-5 flex items-center gap-3">
                <i class="fas fa-plus-circle text-white text-xl"></i>
                <h3 class="font-bold text-white uppercase tracking-wider text-sm">Tambah Tugas Baru</h3>
            </div>
            <form action="/guru/kelas/{{ $jadwal->id }}/tugas" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-2">Judul Tugas</label>
                    <input type="text" name="judul" required placeholder="Contoh: Latihan Soal Bab 1" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-2">Instruksi Pembelajaran</label>
                    <textarea name="deskripsi" rows="3" required placeholder="Tuliskan petunjuk pengerjaan tugas di sini..." class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-purple-500 transition"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-2">Batas Waktu Pengumpulan</label>
                    <input type="datetime-local" name="batas_waktu" required class="w-full p-3 bg-purple-50 border border-purple-100 rounded-xl text-sm text-purple-700 font-bold">
                </div>
                <div class="p-4 bg-gray-50 border border-gray-100 rounded-2xl">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2">Lampiran Dokumen Tambahan (Opsional)</label>
                    <input type="file" name="file_tugas" class="w-full text-xs">
                </div>
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-purple-100 transition-all uppercase tracking-widest text-xs">Simpan Data Tugas</button>
            </form>
        </div>
    </div>
</div>

{{-- PANEL 3: KUIS & UJIAN --}}
<div id="konten-ujian" class="grid grid-cols-1 lg:grid-cols-3 gap-8 hidden transition-all">
    <div class="lg:col-span-2 space-y-4">
        @forelse($ujians as $ujian)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6 group hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-5 w-full">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl shrink-0 group-hover:rotate-6 transition-transform"><i class="fas fa-laptop-code"></i></div>
                    <div class="w-full">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-bold text-gray-800 text-xl leading-tight">{{ $ujian->judul }}</h4>
                            @if($ujian->is_published)
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" title="Status: Aktif"></span>
                            @endif
                        </div>
                        <div class="flex flex-wrap gap-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <span><i class="fas fa-stopwatch text-emerald-500 mr-1"></i> Durasi: {{ $ujian->durasi }} Menit</span>
                            <span><i class="far fa-clock text-blue-500 mr-1"></i> Mulai: {{ $ujian->mulai->format('d M, H:i') }}</span>
                            <span class="bg-emerald-50 text-emerald-700 px-2 rounded">{{ $ujian->soals->count() }} Soal Terdaftar</span>
                        </div>
                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            <a href="/guru/ujian/{{ $ujian->id }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-black px-4 py-2.5 rounded-xl uppercase tracking-wider transition shadow-lg shadow-emerald-50">
                                <i class="fas fa-list-check mr-2"></i> Atur Daftar Soal
                            </a>
                            <form action="/guru/ujian/{{ $ujian->id }}/publish" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-[10px] font-black uppercase tracking-wider px-4 py-2.5 rounded-xl transition {{ $ujian->is_published ? 'bg-amber-50 text-amber-600 border border-amber-100 hover:bg-amber-100' : 'bg-blue-50 text-blue-600 border border-blue-100 hover:bg-blue-100' }}">
                                    <i class="fas {{ $ujian->is_published ? 'fa-eye-slash' : 'fa-paper-plane' }} mr-2"></i>
                                    {{ $ujian->is_published ? 'Batalkan Terbit' : 'Terbitkan ke Siswa' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="flex sm:flex-col gap-2 w-full sm:w-auto">
                    <a href="/guru/ujian/{{ $ujian->id }}/edit" class="flex-1 sm:w-10 sm:h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-blue-50 flex items-center justify-center border border-gray-100"><i class="fas fa-cog"></i></a>
                    
                    <form id="form-hapus-ujian-{{ $ujian->id }}" action="/guru/ujian/{{ $ujian->id }}" method="POST" class="flex-1">
                        @csrf @method('DELETE') 
                        <button type="button" onclick="hapusDataAdminStyle('form-hapus-ujian-{{ $ujian->id }}', 'Evaluasi: {{ $ujian->judul }}')" class="w-full sm:w-10 sm:h-10 rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 flex items-center justify-center border border-gray-100 text-red-500 hover:text-red-700"><i class="fas fa-trash-alt text-sm"></i></button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-16 text-center">
                <div class="w-20 h-20 bg-white text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-3xl"><i class="fas fa-vial"></i></div>
                <h4 class="font-bold text-gray-400">Belum ada evaluasi kuis atau ujian.</h4>
            </div>
        @endforelse
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
            <div class="bg-emerald-600 px-6 py-5 flex items-center gap-3">
                <i class="fas fa-plus-circle text-white text-xl"></i>
                <h3 class="font-bold text-white uppercase tracking-wider text-sm">Tambah Kuis / Ujian</h3>
            </div>
            <form action="/guru/kelas/{{ $jadwal->id }}/ujian" method="POST" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-2">Judul Evaluasi</label>
                    <input type="text" name="judul" required placeholder="Contoh: Ulangan Harian Bab 1" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 transition">
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-500 uppercase mb-2 text-emerald-600">Durasi Pengerjaan (Menit)</label>
                    <input type="number" name="durasi" required placeholder="60" class="w-full p-3 bg-emerald-50 border border-emerald-100 rounded-xl text-sm font-bold text-emerald-700">
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Waktu Akses Dibuka</label>
                        <input type="datetime-local" name="mulai" required class="w-full p-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 text-red-500">Waktu Akses Ditutup</label>
                        <input type="datetime-local" name="selesai" required class="w-full p-2.5 bg-red-50 border border-red-100 rounded-xl text-xs text-red-700 font-medium">
                    </div>
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-emerald-100 transition-all uppercase tracking-widest text-xs">Simpan Jadwal Kuis / Ujian</button>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT: SweetAlert Delete + Logika UI 3 TABS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ==========================================
    // FUNGSI UNIVERSAL DELETE (Gaya Admin)
    // ==========================================
    function hapusDataAdminStyle(formId, namaItem) {
        Swal.fire({
            title: 'Hapus Data?',
            html: `Apakah Anda yakin ingin menghapus <b>${namaItem}</b>?<br><span class="text-sm text-gray-500">Data yang dihapus tidak dapat dikembalikan.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', 
            cancelButtonColor: '#f1f5f9', 
            cancelButtonText: '<span style="color: #475569">Batal</span>',
            confirmButtonText: 'Ya, Hapus!',
            reverseButtons: true,
            customClass: {
                confirmButton: 'shadow-lg shadow-red-200 font-bold',
                cancelButton: 'font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Sedang menghapus data.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                document.getElementById(formId).submit();
            }
        });
    }

    // ==========================================
    // FUNGSI TAB & FORM UI
    // ==========================================
    function toggleTipeInput() {
        const tipe = document.getElementById('tipe_materi').value;
        if (tipe === 'file') {
            document.getElementById('box_file').classList.remove('hidden');
            document.getElementById('box_youtube').classList.add('hidden');
        } else {
            document.getElementById('box_youtube').classList.remove('hidden');
            document.getElementById('box_file').classList.add('hidden');
        }
    }

    function gantiTab(tabAktif) {
        // Matikan semua konten
        ['materi', 'tugas', 'ujian'].forEach(tab => {
            document.getElementById('konten-' + tab).classList.add('hidden');
            let btn = document.getElementById('btn-tab-' + tab);
            btn.className = "flex-1 min-w-[120px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2 text-gray-400 hover:bg-gray-100";
        });

        // Tampilkan tab yang dipilih
        document.getElementById('konten-' + tabAktif).classList.remove('hidden');
        let btnAktif = document.getElementById('btn-tab-' + tabAktif);
        
        // Warna spesifik per tab
        if (tabAktif === 'materi') btnAktif.className = "flex-1 min-w-[120px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2 bg-blue-600 text-white shadow-lg shadow-blue-100";
        if (tabAktif === 'tugas') btnAktif.className = "flex-1 min-w-[120px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2 bg-purple-600 text-white shadow-lg shadow-purple-100";
        if (tabAktif === 'ujian') btnAktif.className = "flex-1 min-w-[120px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2 bg-emerald-600 text-white shadow-lg shadow-emerald-100";

        // Simpan ke memori
        sessionStorage.setItem('tabKelasAktif', tabAktif);
    }

    // Load tab terakhir otomatis
    document.addEventListener('DOMContentLoaded', function() {
        let tabTerakhir = sessionStorage.getItem('tabKelasAktif') || 'materi';
        gantiTab(tabTerakhir);
    });
</script>

@endsection