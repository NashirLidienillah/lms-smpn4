@extends('layouts.app')

@section('content')

<div class="mb-6 bg-gradient-to-r from-blue-700 to-blue-900 rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
    <div class="absolute bottom-0 right-20 w-24 h-24 bg-blue-400 opacity-20 rounded-full blur-xl"></div>
    
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center">
        <div>
            <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👏</h2>
            <p class="text-blue-100">Selamat bekerja dan mendidik generasi bangsa hari ini.</p>
        </div>
        <div class="mt-4 md:mt-0 text-right">
            <span class="block text-xs text-blue-200 mb-1 uppercase tracking-wider font-bold">Tahun Akademik</span>
            <span class="bg-white/20 backdrop-blur-sm border border-white/30 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm inline-block">
                @if($tahunAktif)
                    <i class="fas fa-calendar-alt mr-2"></i> {{ $tahunAktif->nama_tahun }} ({{ $tahunAktif->semester }})
                @else
                    <i class="fas fa-exclamation-triangle text-yellow-300 mr-2"></i> Belum Diatur
                @endif
            </span>
        </div>
    </div>
</div>

<h3 class="text-xl font-bold text-gray-800 mb-4"><i class="fas fa-clipboard-list text-blue-600 mr-2"></i> Jadwal Mengajar Anda</h3>

@if(!$tahunAktif)
    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-xl flex items-center">
        <i class="fas fa-info-circle text-2xl mr-3"></i>
        <p>Tahun Akademik saat ini belum diaktifkan oleh Admin. Anda tidak dapat melihat jadwal.</p>
    </div>
@elseif(count($jadwalMengajar) > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($jadwalMengajar as $jadwal)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow duration-300 relative overflow-hidden group">
            <div class="absolute left-0 top-0 w-1 h-full bg-blue-500 group-hover:w-2 transition-all duration-300"></div>
            
            <div class="flex justify-between items-start mb-3 pl-2">
                <div>
                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded-md">{{ $jadwal->hari }}</span>
                    <p class="text-sm text-gray-500 mt-2 font-medium">
                        <i class="far fa-clock mr-1"></i> {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB
                    </p>
                </div>
                <div class="bg-gray-50 p-2 rounded-lg border border-gray-100 text-center min-w-[3rem]">
                    <span class="block text-xs text-gray-400 font-bold uppercase">Kelas</span>
                    <span class="block text-lg font-bold text-gray-800">{{ $jadwal->kelas->nama_kelas }}</span>
                </div>
            </div>
            
            <div class="pl-2">
                <h4 class="text-lg font-bold text-gray-800 mb-1">{{ $jadwal->mapel->nama_mapel }}</h4>
                
                <a href="/guru/kelas/{{ $jadwal->id }}" class="mt-4 block w-full bg-gray-50 hover:bg-blue-50 text-gray-600 hover:text-blue-600 border border-gray-200 hover:border-blue-200 text-center py-2.5 rounded-lg text-sm font-semibold transition">
                    Masuk Kelas <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <div class="w-20 h-20 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
            <i class="fas fa-mug-hot"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-700 mb-1">Jadwal Kosong</h3>
        <p class="text-gray-500 text-sm">Anda belum memiliki jadwal mengajar pada tahun akademik ini.</p>
    </div>
@endif

@endsection