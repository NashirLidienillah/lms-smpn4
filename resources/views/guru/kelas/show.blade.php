@extends('layouts.app')

@section('content')

{{-- Toast Notifikasi --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-lg shadow-xl border-l-4 border-green-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

@if($errors->any())
    <div id="toast-error" class="fixed top-5 right-5 flex items-start w-full max-w-md p-4 mb-4 text-gray-700 bg-white rounded-lg shadow-xl border-l-4 border-red-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg mt-0.5"><i class="fas fa-exclamation"></i></div>
        <div class="ml-3 text-sm font-medium">
            <span class="font-bold text-red-600 block mb-1">Gagal Menyimpan!</span>
            <ul class="list-disc pl-4 text-gray-600 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-error').remove()"><i class="fas fa-times"></i></button>
    </div>
@endif

<a href="/guru/dashboard" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 transition mb-4 font-medium">
    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
</a>

<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center relative overflow-hidden">
    <div class="absolute left-0 top-0 h-full w-2 bg-blue-500"></div>
    <div class="pl-4">
        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Ruang Kelas Virtual</span>
        <h2 class="text-3xl font-bold text-gray-800">{{ $jadwal->mapel->nama_mapel }}</h2>
        <p class="text-gray-500 mt-1"><i class="fas fa-users mr-1"></i> Kelas {{ $jadwal->kelas->nama_kelas }}</p>
    </div>
    <div class="mt-4 md:mt-0 bg-gray-50 p-4 rounded-xl border border-gray-100 text-right md:min-w-[150px]">
        <span class="block text-xs text-gray-400 font-bold uppercase mb-1">Jadwal Pertemuan</span>
        <span class="block text-gray-800 font-bold"><i class="far fa-calendar-alt text-blue-500 mr-1"></i> {{ $jadwal->hari }}</span>
        <span class="block text-sm text-gray-500 font-medium">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</span>
    </div>
</div>

<div class="flex border-b border-gray-200 mb-6 bg-white rounded-t-xl overflow-hidden shadow-sm cursor-pointer">
    <button onclick="gantiTab('materi')" id="btn-tab-materi" class="flex-1 py-4 text-center font-bold text-blue-600 border-b-4 border-blue-600 bg-blue-50 transition">
        <i class="fas fa-book-open mr-2"></i> Materi
    </button>
    <button onclick="gantiTab('tugas')" id="btn-tab-tugas" class="flex-1 py-4 text-center font-bold text-gray-500 border-b-4 border-transparent hover:bg-gray-50 transition">
        <i class="fas fa-file-upload mr-2"></i> Tugas Esai
    </button>
    <button onclick="gantiTab('ujian')" id="btn-tab-ujian" class="flex-1 py-4 text-center font-bold text-gray-500 border-b-4 border-transparent hover:bg-gray-50 transition">
        <i class="fas fa-laptop-code mr-2"></i> Ujian CBT
    </button>
</div>

<div id="konten-materi" class="grid grid-cols-1 lg:grid-cols-3 gap-6 transition-all duration-300">
    <div class="lg:col-span-2 space-y-4">
        @forelse($materis as $materi)
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200 flex justify-between items-start hover:shadow-md transition">
                <div class="flex items-start">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center text-xl shrink-0 mr-4 {{ $materi->tipe === 'file' ? 'bg-orange-100 text-orange-500' : 'bg-red-100 text-red-500' }}">
                        <i class="fas {{ $materi->tipe === 'file' ? 'fa-file-pdf' : 'fa-play-circle' }}"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-lg">{{ $materi->judul }}</h4>
                        <p class="text-gray-500 text-sm mt-1 mb-3">{{ $materi->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                        <div class="flex items-center space-x-3">
                            <span class="text-xs font-medium text-gray-400"><i class="far fa-clock mr-1"></i> {{ $materi->created_at->diffForHumans() }}</span>
                            @if($materi->tipe === 'file')
                                <a href="{{ asset('storage/materi/' . $materi->file_path) }}" target="_blank" class="text-xs font-bold bg-orange-50 text-orange-600 hover:bg-orange-100 px-3 py-1.5 rounded transition"><i class="fas fa-download mr-1"></i> Buka File</a>
                            @else
                                <a href="{{ $materi->url_youtube }}" target="_blank" class="text-xs font-bold bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded transition"><i class="fas fa-external-link-alt mr-1"></i> Tonton Video</a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-1">
                    <a href="/guru/materi/{{ $materi->id }}/edit" class="text-gray-300 hover:text-blue-500 transition p-2" title="Edit Materi">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="/guru/materi/{{ $materi->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus materi ini?');">
                        @csrf @method('DELETE') 
                        <button type="submit" class="text-gray-300 hover:text-red-500 transition p-2" title="Hapus Materi"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>

            </div>
        @empty
            <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-10 text-center">
                <div class="w-16 h-16 bg-white text-gray-300 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm text-2xl"><i class="fas fa-folder-open"></i></div>
                <h4 class="font-bold text-gray-700 mb-1">Belum Ada Materi</h4>
            </div>
        @endforelse
    </div>
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
            <div class="bg-blue-600 px-5 py-4"><h3 class="font-bold text-white flex items-center"><i class="fas fa-upload mr-2"></i> Bagikan Materi</h3></div>
            <form action="/guru/kelas/{{ $jadwal->id }}/materi" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label><input type="text" name="judul" required class="w-full p-2.5 border border-gray-300 rounded-lg text-sm"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Materi</label>
                    <select name="tipe" id="tipe_materi" onchange="toggleTipeInput()" class="w-full p-2.5 border border-gray-300 rounded-lg text-sm font-medium">
                        <option value="file">📄 Upload Dokumen</option>
                        <option value="youtube">📺 Link Video YouTube</option>
                    </select>
                </div>
                <div id="box_file" class="bg-orange-50 border border-orange-200 p-4 rounded-lg"><label class="block text-sm font-bold text-orange-700 mb-2">Pilih File</label><input type="file" name="file_materi" class="w-full text-sm text-gray-500"></div>
                <div id="box_youtube" class="bg-red-50 border border-red-200 p-4 rounded-lg hidden"><label class="block text-sm font-bold text-red-700 mb-2">URL YouTube</label><input type="url" name="url_youtube" class="w-full p-2.5 border border-red-300 rounded-lg text-sm"></div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg">Bagikan Sekarang</button>
            </form>
        </div>
    </div>
</div>

<div id="konten-tugas" class="grid grid-cols-1 lg:grid-cols-3 gap-6 hidden transition-all duration-300">
    <div class="lg:col-span-2 space-y-4">
        @forelse($tugas as $t)
            <div class="bg-white rounded-xl p-5 shadow-sm border border-l-4 border-l-purple-500 flex justify-between items-start">
                <div class="flex items-start w-full">
                    <div class="w-12 h-12 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-xl shrink-0 mr-4"><i class="fas fa-file-upload"></i></div>
                    <div class="w-full">
                        <h4 class="font-bold text-gray-800 text-lg">{{ $t->judul }}</h4>
                        <span class="text-xs font-bold text-red-600"><i class="fas fa-clock mr-1"></i> Deadline: {{ $t->batas_waktu->format('d M Y, H:i') }}</span>
                        <p class="text-gray-500 text-sm mt-2">{{ $t->deskripsi }}</p>
                        
                        {{-- TOMBOL KOREKSI TUGAS DITAMBAHKAN DI SINI --}}
                        <div class="mt-3">
                            <a href="/guru/tugas/{{ $t->id }}/koreksi" class="inline-block bg-purple-500 hover:bg-purple-600 text-white text-xs font-bold px-4 py-2 rounded shadow-sm transition">
                                <i class="fas fa-check-double mr-1"></i> Koreksi & Nilai Jawaban
                            </a>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-1">
                    <a href="/guru/tugas/{{ $t->id }}/edit" class="text-gray-300 hover:text-purple-500 transition p-2" title="Edit Tugas">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="/guru/tugas/{{ $t->id }}" method="POST" onsubmit="return confirm('Hapus tugas ini?');">
                        @csrf @method('DELETE') 
                        <button type="submit" class="text-gray-300 hover:text-red-500 transition p-2" title="Hapus Tugas"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>

            </div>
        @empty
            <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-10 text-center"><h4 class="font-bold text-gray-700">Belum Ada Tugas</h4></div>
        @endforelse
    </div>
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
            <div class="bg-purple-600 px-5 py-4"><h3 class="font-bold text-white"><i class="fas fa-plus mr-2"></i> Buat Tugas</h3></div>
            <form action="/guru/kelas/{{ $jadwal->id }}/tugas" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                <div><label class="block text-sm font-semibold">Judul</label><input type="text" name="judul" required class="w-full p-2.5 border rounded-lg text-sm bg-gray-50"></div>
                <div><label class="block text-sm font-semibold">Soal/Instruksi</label><textarea name="deskripsi" rows="2" required class="w-full p-2.5 border rounded-lg text-sm bg-gray-50"></textarea></div>
                <div><label class="block text-sm font-semibold">Deadline</label><input type="datetime-local" name="batas_waktu" required class="w-full p-2.5 border rounded-lg text-sm text-red-600 bg-red-50"></div>
                <div class="bg-purple-50 p-4 rounded-lg"><label class="block text-sm font-bold text-purple-700">Lampiran (Opsional)</label><input type="file" name="file_tugas" class="w-full text-sm"></div>
                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-lg">Terbitkan Tugas</button>
            </form>
        </div>
    </div>
</div>

<div id="konten-ujian" class="grid grid-cols-1 lg:grid-cols-3 gap-6 hidden transition-all duration-300">
    <div class="lg:col-span-2 space-y-4">
        @forelse($ujians as $ujian)
            <div class="bg-white rounded-xl p-5 shadow-sm border border-l-4 border-l-emerald-500 flex justify-between items-center hover:shadow-md transition">
                <div class="flex items-center w-full">
                    <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl shrink-0 mr-4">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <div class="w-full">
                        <h4 class="font-bold text-gray-800 text-lg mb-1">{{ $ujian->judul }}</h4>
                        <div class="flex space-x-4 text-sm text-gray-500 font-medium">
                            <span><i class="fas fa-stopwatch text-emerald-500 mr-1"></i> {{ $ujian->durasi }} Menit</span>
                            <span><i class="far fa-calendar-check text-blue-500 mr-1"></i> Buka: {{ $ujian->mulai->format('d M, H:i') }}</span>
                        </div>
                        <div class="mt-3 flex items-center space-x-2">
                            <a href="/guru/ujian/{{ $ujian->id }}" class="inline-block bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold px-4 py-2 rounded shadow-sm transition">
                                <i class="fas fa-list-ol mr-1"></i> Kelola Pertanyaan
                            </a>
                            <span class="text-xs text-gray-400 font-bold border-r pr-2">{{ $ujian->soals->count() ?? 0 }} Soal</span>
                            
                            {{-- TOMBOL PUBLISH/DRAFT --}}
                            <form action="/guru/ujian/{{ $ujian->id }}/publish" method="POST" class="inline-block">
                                @csrf @method('PATCH')
                                @if($ujian->is_published)
                                    <button type="submit" class="bg-blue-100 text-blue-700 hover:bg-blue-200 text-xs font-bold px-3 py-1.5 rounded transition">
                                        <i class="fas fa-eye mr-1"></i> Dibagikan (Klik untuk Tarik)
                                    </button>
                                @else
                                    <button type="submit" class="bg-orange-100 text-orange-700 hover:bg-orange-200 text-xs font-bold px-3 py-1.5 rounded transition">
                                        <i class="fas fa-eye-slash mr-1"></i> Draft (Klik untuk Bagikan)
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-1">
                    <a href="/guru/ujian/{{ $ujian->id }}/edit" class="text-gray-300 hover:text-emerald-500 transition p-2" title="Edit Pengaturan Ujian">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="/guru/ujian/{{ $ujian->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus Ujian CBT ini beserta seluruh soalnya?');">
                        @csrf @method('DELETE') 
                        <button type="submit" class="text-gray-300 hover:text-red-500 transition p-2" title="Hapus Ujian"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>

            </div>
        @empty
            <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-10 text-center">
                <div class="w-16 h-16 bg-white text-emerald-300 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm text-2xl"><i class="fas fa-cogs"></i></div>
                <h4 class="font-bold text-gray-700 mb-1">Belum Ada Ujian CBT</h4>
                <p class="text-sm text-gray-500">Buat sesi ujian pilihan ganda otomatis untuk kelas ini.</p>
            </div>
        @endforelse
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
            <div class="bg-emerald-600 px-5 py-4"><h3 class="font-bold text-white"><i class="fas fa-plus-square mr-2"></i> Buat Ujian CBT</h3></div>
            <form action="/guru/kelas/{{ $jadwal->id }}/ujian" method="POST" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Ujian <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" required placeholder="Contoh: UTS Ganjil" class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Durasi Pengerjaan <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="durasi" required min="1" placeholder="60" class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50 pr-16">
                        <span class="absolute right-3 top-2.5 text-gray-400 text-sm font-bold">Menit</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Dibuka <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="mulai" required class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-emerald-50 text-emerald-700 font-medium">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Ditutup <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="selesai" required class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-red-50 text-red-700 font-medium">
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg shadow-md mt-2">
                    Buat Sesi Ujian <i class="fas fa-arrow-right ml-1"></i>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT: Logika 3 TABS dengan Memory Browser --}}
<script>
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
        // Matikan semua tab dulu
        ['materi', 'tugas', 'ujian'].forEach(tab => {
            document.getElementById('konten-' + tab).classList.add('hidden');
            document.getElementById('btn-tab-' + tab).className = "flex-1 py-4 text-center font-bold text-gray-500 border-b-4 border-transparent hover:bg-gray-50 transition";
        });

        // Nyalakan tab yang dipilih beserta warna khususnya
        document.getElementById('konten-' + tabAktif).classList.remove('hidden');
        let btnAktif = document.getElementById('btn-tab-' + tabAktif);
        
        if (tabAktif === 'materi') btnAktif.className = "flex-1 py-4 text-center font-bold text-blue-600 border-b-4 border-blue-600 bg-blue-50 transition";
        if (tabAktif === 'tugas') btnAktif.className = "flex-1 py-4 text-center font-bold text-purple-600 border-b-4 border-purple-600 bg-purple-50 transition";
        if (tabAktif === 'ujian') btnAktif.className = "flex-1 py-4 text-center font-bold text-emerald-600 border-b-4 border-emerald-600 bg-emerald-50 transition";

        // SIMPAN MEMORI: Catat tab terakhir yang diklik ke penyimpanan sementara browser
        sessionStorage.setItem('tabKelasAktif', tabAktif);
    }

    // AUTO-LOAD: Saat halaman selesai di-refresh (habis submit form)
    document.addEventListener('DOMContentLoaded', function() {
        let tabTerakhir = sessionStorage.getItem('tabKelasAktif') || 'materi';
        gantiTab(tabTerakhir);
    });
</script>

@endsection