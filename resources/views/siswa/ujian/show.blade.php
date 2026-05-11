@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-200">
        <div class="bg-emerald-600 p-6 text-white text-center">
            <i class="fas fa-file-signature text-5xl mb-4"></i>
            <h1 class="text-2xl font-bold font-serif">{{ $ujian->judul }}</h1>
        </div>
        
        <div class="p-8">
            {{-- Cek Hasil Ujian Langsung dari Database --}}
            @php
                $hasil = \App\Models\HasilUjian::where('siswa_id', auth()->id())->where('ujian_id', $ujian->id)->first();
            @endphp

            <div class="grid grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <p class="text-gray-500 text-xs uppercase font-bold mb-1">Durasi</p>
                    <p class="text-lg font-bold text-gray-800">{{ $ujian->durasi }} Menit</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <p class="text-gray-500 text-xs uppercase font-bold mb-1">Jumlah Soal</p>
                    <p class="text-lg font-bold text-gray-800">{{ $ujian->soals->count() }} Butir</p>
                </div>
            </div>

            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-8 text-amber-800">
                <h4 class="font-bold mb-1"><i class="fas fa-exclamation-triangle mr-2"></i> Peraturan Ujian:</h4>
                <ul class="text-sm list-disc ml-5 space-y-1">
                    <li>Jangan menyegarkan (refresh) halaman saat ujian berlangsung.</li>
                    <li>Waktu akan terus berjalan meskipun Anda menutup browser.</li>
                    <li>Pastikan koneksi internet stabil.</li>
                </ul>
            </div>

            <div class="flex flex-col space-y-3">
                @if($hasil)
                    {{-- Tampilan Jika Sudah Mengerjakan (Menampilkan Nilai & Statistik Langsung) --}}
                    <div class="bg-blue-50 border border-blue-200 p-6 rounded-xl text-center shadow-inner">
                        <i class="fas fa-check-circle text-green-500 text-5xl mb-3"></i>
                        <h3 class="text-xl font-bold text-gray-800 mb-1">Sudah Dikerjakan</h3>
                        <p class="text-sm text-gray-600 mb-6">Anda telah menyelesaikan soal pilihan ganda ini.</p>
                        
                        <div class="mb-6 bg-white py-5 px-8 rounded-xl border border-blue-100 shadow-sm inline-block w-full sm:w-auto">
                            <span class="block text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Nilai Akhir Anda</span>
                            <span class="text-6xl font-black {{ $hasil->nilai >= 75 ? 'text-green-600' : 'text-red-500' }} block mb-4">
                                {{ $hasil->nilai }}
                            </span>
                            
                            {{-- Baris Statistik Benar Salah --}}
                            <div class="flex justify-center gap-8 border-t border-gray-100 pt-4 mt-2">
                                <div>
                                    <span class="block text-xs text-gray-500 uppercase font-semibold mb-1">Benar</span>
                                    <span class="text-2xl font-bold text-emerald-500">{{ $hasil->jumlah_benar }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-gray-500 uppercase font-semibold mb-1">Salah</span>
                                    <span class="text-2xl font-bold text-red-500">{{ $hasil->jumlah_salah }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <a href="/siswa/dashboard" class="inline-flex items-center justify-center w-full sm:w-auto bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-md">
                                <i class="fas fa-arrow-left mr-2"></i> KEMBALI KE DASHBOARD
                            </a>
                        </div>
                    </div>
                @else
                    {{-- Tampilan Jika Belum Mengerjakan --}}
                    <a href="/siswa/ujian/{{ $ujian->id }}/kerjakan" 
                       class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-center font-bold py-4 rounded-xl transition shadow-lg text-lg">
                        MULAI KERJAKAN SEKARANG
                    </a>
                    
                    <a href="/siswa/dashboard" class="text-center text-gray-500 hover:text-gray-700 text-sm font-medium">
                        Nanti Saja, Kembali ke Dashboard
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection