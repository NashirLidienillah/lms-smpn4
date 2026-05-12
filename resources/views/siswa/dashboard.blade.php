@extends('layouts.app')

@section('content')

<div class="space-y-8">
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-blue-700 to-blue-800 rounded-3xl p-8 md:p-12 text-white shadow-2xl">
        <div class="absolute -right-10 -top-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute left-1/4 bottom-0 w-32 h-32 bg-indigo-400/20 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-center md:text-left">
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-4 py-1.5 rounded-full mb-4">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em]">Siswa Aktif</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-black mb-3 tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-blue-100 text-lg opacity-90 font-medium max-w-xl">Semangat belajarnya hari ini! Semua materi dan tugasmu sudah siap di ruang kelas virtual.</p>
            </div>
            
            <div class="shrink-0 w-full md:w-auto">
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-6 rounded-3xl shadow-inner text-center">
                    <i class="fas fa-book-reader text-3xl text-blue-200 mb-2"></i>
                    <span class="block text-[10px] text-blue-200 mb-1 uppercase tracking-widest font-black">Total Mata Pelajaran</span>
                    <span class="text-3xl font-black tracking-tighter">{{ count($jadwals) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="flex items-center justify-between mb-8 px-2">
            <h3 class="text-xl font-black text-gray-800 flex items-center gap-3 uppercase tracking-tight">
                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                    <i class="fas fa-th-large text-sm"></i>
                </div>
                Ruang Belajar Kamu
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($jadwals as $jadwal)
                <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group flex flex-col">
                    
                    <div class="h-32 bg-gradient-to-br from-blue-500 to-indigo-700 p-6 relative flex items-end">
                        <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:rotate-12 group-hover:scale-150 transition-all duration-700">
                            <i class="fas fa-graduation-cap text-7xl text-white"></i>
                        </div>
                        
                        <div class="absolute top-4 left-6">
                            <span class="bg-white/20 backdrop-blur-md text-white text-[10px] font-black px-3 py-1.5 rounded-xl border border-white/30 uppercase tracking-widest shadow-sm">
                                <i class="far fa-calendar-alt mr-1"></i> {{ $jadwal->hari }}
                            </span>
                        </div>
                        
                        <div class="relative z-10">
                            <h3 class="text-2xl font-black text-white tracking-tight leading-tight">{{ $jadwal->mapel->nama_mapel }}</h3>
                        </div>
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <span class="block text-[10px] text-gray-400 font-black uppercase tracking-wider">Guru Pengampu</span>
                                <p class="text-sm font-bold text-gray-700 leading-none mt-0.5">{{ $jadwal->user->name }}</p>
                            </div>
                        </div>

                        <div class="bg-indigo-50/50 border border-indigo-100/50 p-4 rounded-2xl mb-8 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-indigo-600">
                                    <i class="far fa-clock text-xs"></i>
                                </div>
                                <span class="text-xs font-black text-indigo-900 uppercase tracking-tight">Jam Pelajaran</span>
                            </div>
                            <span class="text-sm font-black text-indigo-700 bg-white px-3 py-1 rounded-lg shadow-sm border border-indigo-100">
                                {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}
                            </span>
                        </div>
                        
                        <a href="/siswa/kelas/{{ $jadwal->id }}" class="mt-auto block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl text-center text-sm uppercase tracking-[0.2em] shadow-lg shadow-indigo-100 transition-all duration-300 active:scale-95 flex items-center justify-center gap-2 group-hover:gap-4">
                            Masuk Kelas 
                            <i class="fas fa-chevron-right text-xs transition-transform"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-[3rem] shadow-sm border-2 border-dashed border-gray-100 p-20 text-center">
                    <div class="w-24 h-24 bg-gray-50 text-gray-200 rounded-3xl flex items-center justify-center mx-auto mb-6 text-4xl shadow-inner transform -rotate-6">
                        <i class="fas fa-mug-hot"></i>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 mb-2 tracking-tight">Belum Ada Jadwal</h3>
                    <p class="text-gray-500 max-w-sm mx-auto leading-relaxed font-medium">Sepertinya admin sekolah belum memasukkan jadwal pelajaran untuk kelasmu. Silakan istirahat sejenak!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection