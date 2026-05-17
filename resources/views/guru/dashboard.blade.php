@extends('layouts.app')

@section('content')

<div class="space-y-8">
    {{-- Banner Selamat Datang --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-blue-800 rounded-3xl p-8 md:p-10 text-white shadow-xl">
        <div class="absolute -right-10 -top-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-blue-400/20 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight">Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="text-blue-100 text-lg font-medium opacity-90">Silakan periksa dan kelola jadwal mengajar Anda pada tahun ajaran yang berjalan.</p>
            </div>
            
            <div class="shrink-0">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl shadow-inner text-center md:text-right">
                    <span class="block text-[10px] text-blue-200 mb-1 uppercase tracking-[0.2em] font-black">Tahun Ajaran Aktif</span>
                    <div class="flex items-center justify-center md:justify-end gap-2 text-white">
                        <i class="fas fa-calendar-check text-blue-300"></i>
                        @if($tahunAktif)
                            <span class="font-bold text-sm">{{ $tahunAktif->nama_tahun }} <span class="mx-1 opacity-50">•</span> {{ $tahunAktif->semester }}</span>
                        @else
                            <span class="font-bold text-sm text-yellow-300">Belum Diatur Admin</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Area Jadwal Mengajar --}}
    <div>
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center shadow-sm">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                Jadwal Mengajar Anda
            </h3>
            @if($tahunAktif && count($jadwalMengajar) > 0)
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ count($jadwalMengajar) }} Kelas Terdaftar</span>
            @endif
        </div>

        @if(!$tahunAktif)
            <div class="bg-amber-50 border border-amber-200 p-6 rounded-2xl flex items-start gap-4">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center shrink-0">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-amber-900">Tahun Ajaran Belum Aktif</h4>
                    <p class="text-amber-700 text-sm leading-relaxed mt-1">Data jadwal mengajar akan muncul secara otomatis setelah admin sekolah mengaktifkan data tahun ajaran terbaru pada sistem.</p>
                </div>
            </div>

        @elseif(count($jadwalMengajar) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($jadwalMengajar as $jadwal)
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex justify-between items-start mb-6">
                        <div class="space-y-1">
                            <span class="inline-block bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full border border-blue-100">
                                {{ $jadwal->hari }}
                            </span>
                            <div class="flex items-center gap-2 text-gray-400 text-xs font-medium">
                                <i class="far fa-clock"></i>
                                {{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }} WIB
                            </div>
                        </div>
                        <div class="w-12 h-12 bg-gray-50 group-hover:bg-blue-600 group-hover:text-white text-gray-400 rounded-2xl flex flex-col items-center justify-center transition-colors duration-300 border border-gray-100 group-hover:border-blue-500">
                            <span class="text-[9px] font-black uppercase opacity-60">Kelas</span>
                            <span class="text-lg font-bold leading-none">{{ $jadwal->kelas->nama_kelas }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="text-xl font-bold text-gray-800 leading-tight group-hover:text-blue-700 transition-colors">{{ $jadwal->mapel->nama_mapel }}</h4>
                        <p class="text-xs text-gray-400 mt-1">SMPN 4 Kota Serang</p>
                    </div>
                    
                    <a href="/guru/kelas/{{ $jadwal->id }}" class="flex items-center justify-center gap-2 w-full bg-gray-50 group-hover:bg-blue-600 text-gray-600 group-hover:text-white py-3.5 rounded-2xl text-sm font-bold transition-all duration-300 border border-gray-100 group-hover:border-blue-500 group-hover:shadow-lg group-hover:shadow-blue-200">
                        Masuk Ruang Kelas
                        <i class="fas fa-chevron-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                @endforeach
            </div>

        @else
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-16 text-center">
                <div class="w-24 h-24 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl shadow-inner">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Jadwal Mengajar</h3>
                <p class="text-gray-500 text-sm max-w-xs mx-auto leading-relaxed">Akun Anda belum terplot ke dalam jadwal mengajar kelas. Silakan hubungi bagian Kurikulum sekolah untuk konfirmasi.</p>
            </div>
        @endif
    </div>

    {{-- Kotak Catatan Informasi Teknis (Bukan Tips Robot) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-emerald-50 border border-emerald-100 p-6 rounded-3xl">
            <h5 class="text-emerald-900 font-bold flex items-center gap-2 mb-2">
                <i class="fas fa-folder-open"></i> Panduan Kelola Kelas
            </h5>
            <p class="text-emerald-700 text-xs leading-relaxed">Gunakan tombol masuk ruang kelas untuk mengunggah materi, memberikan lembar kerja tugas, serta membuat kuis latihan untuk siswa.</p>
        </div>
        <div class="bg-indigo-50 border border-indigo-100 p-6 rounded-3xl">
            <h5 class="text-indigo-900 font-bold flex items-center gap-2 mb-2">
                <i class="fas fa-file-invoice"></i> Catatan Rekapitulasi
            </h5>
            <p class="text-indigo-700 text-xs leading-relaxed">Seluruh akumulasi nilai dari pengumpulan tugas serta pengerjaan ujian oleh siswa akan tersimpan secara otomatis pada basis data sistem.</p>
        </div>
    </div>
</div>

@endsection