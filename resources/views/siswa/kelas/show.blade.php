@extends('layouts.app')

@section('content')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="space-y-6">
    {{-- Tombol Kembali & Header Kelas --}}
    <div class="flex flex-col gap-4">
        <a href="/siswa/dashboard" class="group inline-flex items-center text-sm font-bold text-gray-400 hover:text-blue-600 transition">
            <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-blue-50 flex items-center justify-center mr-3 transition">
                <i class="fas fa-arrow-left text-xs"></i>
            </div>
            Kembali ke Beranda Siswa
        </a>
        
        <div class="bg-gradient-to-br from-blue-600 to-indigo-800 rounded-[2rem] p-8 md:p-10 text-white shadow-xl relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-3">
                    <span class="bg-white/20 backdrop-blur-md text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-white/30">Ruang Belajar</span>
                    <span class="text-blue-200 opacity-50">•</span>
                    <span class="text-sm font-bold text-blue-100">Siswa Aktif</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-black mb-2 tracking-tight">{{ $jadwal->mapel->nama_mapel }}</h1>
                <div class="flex items-center gap-2 text-blue-100 font-medium opacity-90">
                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center border border-white/20">
                        <i class="fas fa-user-tie text-xs"></i>
                    </div>
                    <span>Guru Pengampu: {{ $jadwal->user->name }}</span>
                </div>
            </div>
            <i class="fas fa-book-reader absolute right-10 bottom-4 text-white opacity-5 text-9xl hidden md:block"></i>
        </div>
    </div>

    {{-- Sistem 3 Tab Menu (Materi, Tugas, Kuis & Ujian) --}}
    <div x-data="{ tab: 'materi' }" class="space-y-6">
        <div class="bg-gray-100/50 p-1.5 rounded-2xl flex flex-wrap gap-1 shadow-inner border border-gray-200/50">
            <button @click="tab = 'materi'" :class="tab === 'materi' ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 'text-gray-400 hover:bg-gray-100'" 
                class="flex-1 min-w-[100px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2">
                <i class="fas fa-book-open"></i> Materi
            </button>
            <button @click="tab = 'tugas'" :class="tab === 'tugas' ? 'bg-purple-600 text-white shadow-lg shadow-purple-100' : 'text-gray-400 hover:bg-gray-100'" 
                class="flex-1 min-w-[100px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2">
                <i class="fas fa-tasks"></i> Tugas Kelas
            </button>
            <button @click="tab = 'ujian'" :class="tab === 'ujian' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-100' : 'text-gray-400 hover:bg-gray-100'" 
                class="flex-1 min-w-[100px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2">
                <i class="fas fa-vial"></i> Kuis & Ujian
            </button>
        </div>

        {{-- KONTEN TAB 1: MATERI LITERASI --}}
        <div x-show="tab === 'materi'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($materis as $materi)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl shrink-0 transition-transform group-hover:rotate-6 {{ !empty($materi->file_path) ? 'bg-orange-50 text-orange-500' : 'bg-red-50 text-red-500' }}">
                            <i class="fas {{ !empty($materi->file_path) ? 'fa-file-pdf' : 'fa-play-circle' }}"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Diterbitkan: {{ $materi->created_at->format('d M Y') }}</span>
                            <h3 class="text-lg font-black text-gray-800 leading-tight group-hover:text-blue-600 transition-colors">{{ $materi->judul }}</h3>
                        </div>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-2">{{ $materi->deskripsi ?? 'Silakan akses materi yang telah diunggah guru untuk dipelajari.' }}</p>
                    
                    <div class="flex flex-wrap gap-2 mt-auto">
                        @if(!empty($materi->file_path))
                            <a href="{{ asset('storage/materi/' . $materi->file_path) }}" target="_blank" class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-orange-50 text-orange-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 hover:text-white transition-all border border-orange-100">
                                <i class="fas fa-file-download mr-2"></i> Unduh Materi Berkas
                            </a>
                        @endif
                        @if(!empty($materi->url_youtube))
                            <a href="{{ $materi->url_youtube }}" target="_blank" class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-red-50 text-red-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all border border-red-100">
                                <i class="fab fa-youtube mr-2"></i> Putar Video Pembelajaran
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-[2rem] border-2 border-dashed border-gray-100 p-16 text-center">
                    <div class="w-16 h-16 bg-gray-50 text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h4 class="font-bold text-gray-400">Belum ada materi pembelajaran yang diunggah oleh guru.</h4>
                </div>
            @endforelse
        </div>

        {{-- KONTEN TAB 2: TUGAS KELAS --}}
        <div x-show="tab === 'tugas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" style="display:none" class="space-y-4">
            @forelse($tugass as $tugas)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6 group hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute left-0 top-0 h-full w-1.5 bg-purple-500"></div>
                    <div class="flex items-center gap-5 w-full">
                        <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl shrink-0"><i class="fas fa-file-signature"></i></div>
                        <div>
                            <h3 class="text-xl font-black text-gray-800 tracking-tight">{{ $tugas->judul }}</h3>
                            <div class="flex items-center gap-3 mt-1">
                                <span class="text-[10px] font-black text-red-500 uppercase tracking-widest flex items-center gap-1 bg-red-50 px-2 py-0.5 rounded">
                                    <i class="fas fa-hourglass-half"></i> Batas Waktu: {{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M, H:i') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <a href="/siswa/tugas/{{ $tugas->id }}" class="w-full md:w-auto bg-purple-600 hover:bg-purple-700 text-white px-8 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-purple-100 transition-all flex items-center justify-center gap-2">
                        Buka Tugas <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            @empty
                <div class="bg-white rounded-[2rem] border-2 border-dashed border-gray-100 p-16 text-center">
                    <div class="w-16 h-16 bg-gray-50 text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <h4 class="font-bold text-gray-400">Belum ada tugas aktif saat ini.</h4>
                </div>
            @endforelse
        </div>

        {{-- KONTEN TAB 3: KUIS & UJIAN EVALUASI --}}
        <div x-show="tab === 'ujian'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" style="display:none" class="space-y-4">
            @forelse($ujians as $ujian)
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6 group hover:shadow-xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute left-0 top-0 h-full w-2 bg-emerald-500 group-hover:w-3 transition-all"></div>
                    <div class="text-center md:text-left flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl shrink-0 shadow-inner rotate-3 group-hover:rotate-0 transition-transform">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-800 tracking-tight">{{ $ujian->judul }}</h3>
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-[10px] font-black text-gray-400 uppercase tracking-widest mt-2">
                                <span class="flex items-center gap-1.5"><i class="fas fa-stopwatch text-emerald-500"></i> Durasi: {{ $ujian->durasi }} Menit</span>
                                <span class="flex items-center gap-1.5"><i class="fas fa-calendar-alt text-blue-500"></i> Tanggal: {{ $ujian->mulai->format('d M Y') }}</span>
                                <span class="flex items-center gap-1.5 text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">{{ $ujian->soals->count() }} Butir Soal</span>
                            </div>
                        </div>
                    </div>
                    <a href="/siswa/ujian/{{ $ujian->id }}" class="w-full md:w-auto bg-emerald-600 text-white px-10 py-4 rounded-2xl font-black hover:bg-emerald-700 shadow-xl shadow-emerald-100 transition-all uppercase tracking-widest text-xs flex items-center justify-center gap-2 group-hover:gap-4">
                        Mulai Pengerjaan <i class="fas fa-play text-[10px]"></i>
                    </a>
                </div>
            @empty
                <div class="bg-white rounded-[2rem] border-2 border-dashed border-gray-200 p-16 text-center">
                    <div class="w-16 h-16 bg-gray-50 text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner">
                        <i class="fas fa-vial"></i>
                    </div>
                    <h4 class="font-bold text-gray-400">Belum ada jadwal kuis atau ujian saat ini.</h4>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection