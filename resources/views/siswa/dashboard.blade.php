@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Halo, {{ Auth::user()->name }}! 👋</h1>
    <p class="text-gray-500 mt-2 text-lg">Selamat datang di Ruang Belajar SMPN 4 Kota Serang. Semangat belajarnya hari ini!</p>
</div>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 mb-8 flex justify-between items-center border-l-4 border-l-blue-500 relative overflow-hidden">
    <div class="absolute right-0 top-0 opacity-10">
        <i class="fas fa-graduation-cap text-9xl -mt-4 -mr-4 text-blue-500"></i>
    </div>
    <div class="relative z-10">
        <h2 class="text-xl font-bold text-gray-800">Kelas Aktif Kamu</h2>
        <p class="text-sm text-gray-500 mt-1">Pilih mata pelajaran di bawah ini untuk melihat materi, tugas, dan ujian.</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($jadwals as $jadwal)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition duration-300 flex flex-col group">
            {{-- Header Kartu Kelas --}}
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-20 transform group-hover:scale-110 transition duration-500">
                    <i class="fas fa-book-reader text-6xl text-white"></i>
                </div>
                <div class="flex justify-between items-start relative z-10">
                    <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full backdrop-blur-sm shadow-sm">
                        <i class="far fa-calendar-alt mr-1"></i> {{ $jadwal->hari }}
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-white mt-4 relative z-10">{{ $jadwal->mapel->nama_mapel }}</h3>
                <p class="text-blue-100 mt-1 text-sm font-medium relative z-10"><i class="fas fa-chalkboard-teacher mr-1"></i> Bpk/Ibu {{ $jadwal->user->name }}</p>
            </div>
            
            {{-- Body Kartu Kelas --}}
            <div class="p-5 flex-1 flex flex-col justify-between">
                <div class="mb-5">
                    <div class="flex items-center text-sm text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3 shrink-0">
                            <i class="far fa-clock text-lg"></i>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase">Waktu Pelajaran</span>
                            <span class="font-bold text-gray-800">{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB</span>
                        </div>
                    </div>
                </div>
                
                {{-- Tombol Masuk --}}
                <a href="/siswa/kelas/{{ $jadwal->id }}" class="block w-full text-center bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white font-bold py-3 rounded-xl transition duration-300 border border-blue-200 hover:border-blue-600 shadow-sm">
                    Masuk Ruang Kelas <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white rounded-2xl shadow-sm border border-dashed border-gray-300 p-12 text-center">
            <div class="w-24 h-24 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-5 text-5xl shadow-inner">
                <i class="fas fa-mug-hot"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum Ada Jadwal Kelas</h3>
            <p class="text-gray-500 max-w-md mx-auto">Sepertinya belum ada jadwal mata pelajaran yang di-assign ke kelasmu. Silakan istirahat atau hubungi wali kelas.</p>
        </div>
    @endforelse
</div>
@endsection