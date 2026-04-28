@extends('layouts.app')

@section('content')
<!-- Alpine JS untuk Tab -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="mb-6">
    <a href="/siswa/dashboard" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 transition mb-4 font-medium">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
    </a>
    
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2">{{ $jadwal->mapel->nama_mapel }}</h1>
            <p class="text-blue-100 italic"><i class="fas fa-chalkboard-teacher mr-2"></i> Guru Pengajar: {{ $jadwal->user->name }}</p>
        </div>
        <i class="fas fa-book-reader absolute right-8 bottom-4 text-white opacity-10 text-9xl"></i>
    </div>
</div>

<div x-data="{ tab: 'materi' }" class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- Header Tab -->
    <div class="flex border-b border-gray-200 bg-gray-50">
        <button @click="tab = 'materi'" :class="tab === 'materi' ? 'border-b-2 border-blue-500 text-blue-600 bg-white' : 'text-gray-500 hover:text-gray-700'" class="flex-1 py-4 px-6 text-center font-bold text-sm transition focus:outline-none">
            <i class="fas fa-book-open mr-2"></i> Materi
        </button>
        <button @click="tab = 'tugas'" :class="tab === 'tugas' ? 'border-b-2 border-blue-500 text-blue-600 bg-white' : 'text-gray-500 hover:text-gray-700'" class="flex-1 py-4 px-6 text-center font-bold text-sm transition focus:outline-none">
            <i class="fas fa-tasks mr-2"></i> Tugas Esai
        </button>
        <button @click="tab = 'ujian'" :class="tab === 'ujian' ? 'border-b-2 border-blue-500 text-blue-600 bg-white' : 'text-gray-500 hover:text-gray-700'" class="flex-1 py-4 px-6 text-center font-bold text-sm transition focus:outline-none">
            <i class="fas fa-laptop-code mr-2"></i> Ujian CBT
        </button>
    </div>

<!-- Tab Materi -->
<div x-show="tab === 'materi'" class="p-6">
    @forelse($materis as $materi)
        <div class="border border-gray-100 rounded-xl p-5 mb-4 hover:shadow-md transition bg-white">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $materi->judul }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $materi->deskripsi }}</p>
                    
                    <div class="flex flex-wrap gap-2">
                        {{-- CEK FILE: Menggunakan kolom file_path --}}
                        @if(!empty($materi->file_path))
                            <a href="{{ asset('storage/materi/' . $materi->file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-orange-100 text-orange-700 rounded-lg text-sm font-bold hover:bg-orange-600 hover:text-white transition shadow-sm">
                                <i class="fas fa-file-pdf mr-2"></i> Buka File Materi
                            </a>
                        @endif

                        {{-- CEK VIDEO: Menggunakan kolom url_youtube --}}
                        @if(!empty($materi->url_youtube))
                            <a href="{{ $materi->url_youtube }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-bold hover:bg-red-600 hover:text-white transition shadow-sm">
                                <i class="fab fa-youtube mr-2"></i> Tonton Video
                            </a>
                        @endif

                        {{-- Jika Keduanya Kosong --}}
                        @if(empty($materi->file_path) && empty($materi->url_youtube))
                            <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200 italic">
                                <i class="fas fa-info-circle mr-1"></i> Materi Teks Saja
                            </span>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block">{{ $materi->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-10">
            <i class="fas fa-folder-open text-gray-300 text-5xl mb-3"></i>
            <p class="text-gray-400 italic">Belum ada materi pelajaran.</p>
        </div>
    @endforelse
</div>

    <!-- Tab Tugas -->
    <div x-show="tab === 'tugas'" class="p-6" style="display:none">
        @forelse($tugass as $tugas)
            <div class="border border-gray-100 rounded-xl p-5 mb-4 bg-amber-50/20 hover:border-amber-200 transition">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-bold text-gray-800">{{ $tugas->judul }}</h3>
                    <span class="text-xs font-bold text-amber-600 bg-amber-100 px-2 py-1 rounded">
                        Deadline: {{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M, H:i') }}
                    </span>
                </div>
                <p class="text-sm text-gray-600 mb-4">{{ Str::limit($tugas->deskripsi, 150) }}</p>
                <a href="/siswa/tugas/{{ $tugas->id }}" class="inline-flex items-center px-4 py-2 bg-amber-500 text-white rounded-lg text-sm font-bold hover:bg-amber-600 shadow-sm transition">
                    Kerjakan Tugas <i class="fas fa-external-link-alt ml-2 text-xs"></i>
                </a>
            </div>
        @empty
            <div class="text-center py-10">
                <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-3"></i>
                <p class="text-gray-400 italic">Tidak ada tugas untuk saat ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Tab Ujian -->
    <div x-show="tab === 'ujian'" class="p-6" style="display:none">
        @forelse($ujians as $ujian)
            <div class="border border-gray-100 rounded-xl p-6 mb-4 flex flex-col md:flex-row justify-between items-center bg-white hover:border-emerald-200 transition shadow-sm">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $ujian->judul }}</h3>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-sm text-gray-500 mt-2">
                        <span><i class="fas fa-clock mr-1 text-emerald-500"></i> {{ $ujian->durasi }} Menit</span>
                        <span><i class="fas fa-calendar-alt mr-1 text-blue-500"></i> {{ $ujian->mulai->format('d M Y') }}</span>
                        <span><i class="fas fa-list-ol mr-1 text-purple-500"></i> {{ $ujian->soals->count() }} Soal</span>
                    </div>
                </div>
                <a href="/siswa/ujian/{{ $ujian->id }}" class="w-full md:w-auto bg-emerald-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-emerald-700 shadow-md transition text-center">
                    <i class="fas fa-play mr-2 text-sm"></i> Ikuti Ujian
                </a>
            </div>
        @empty
            <div class="text-center py-10">
                <i class="fas fa-laptop-house text-gray-300 text-5xl mb-3"></i>
                <p class="text-gray-400 italic">Belum ada jadwal ujian CBT.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection