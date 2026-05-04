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

<a href="/guru/kelas/{{ $ujian->guru_mapel_id }}" class="inline-flex items-center text-sm text-gray-500 hover:text-emerald-600 transition mb-4 font-medium">
    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Ruang Kelas
</a>

<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center relative overflow-hidden">
    <div class="absolute left-0 top-0 h-full w-2 bg-emerald-500"></div>
    <div class="pl-4">
        <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Dapur Ujian CBT</span>
        <h2 class="text-3xl font-bold text-gray-800">{{ $ujian->judul }}</h2>
        <p class="text-gray-500 mt-1"><i class="fas fa-stopwatch mr-1"></i> Durasi: {{ $ujian->durasi }} Menit &nbsp; | &nbsp; <i class="fas fa-list-ol mr-1"></i> Total Soal: {{ count($ujian->soals) }}</p>
    </div>
    <div class="mt-4 md:mt-0 bg-gray-50 p-4 rounded-xl border border-gray-100 text-right md:min-w-[150px]">
        <span class="block text-xs text-gray-400 font-bold uppercase mb-1">Jadwal Akses</span>
        <span class="block text-gray-800 font-bold text-sm"><i class="fas fa-door-open text-emerald-500 mr-1"></i> {{ $ujian->mulai->format('d M Y, H:i') }}</span>
        <span class="block text-gray-800 font-bold text-sm mt-1"><i class="fas fa-door-closed text-red-500 mr-1"></i> {{ $ujian->selesai->format('d M Y, H:i') }}</span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="lg:col-span-2 space-y-4">
    {{-- Container Flex untuk menyandingkan Judul dan Tombol --}}
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-bold text-gray-800 text-lg flex items-center">
            <i class="fas fa-clipboard-list text-emerald-500 mr-2"></i> Daftar Pertanyaan
        </h3>
        
        {{-- Tombol Lihat Rekap Nilai --}}
        <a href="/guru/ujian/{{ $ujian->id }}/rekap" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-sm">
            <i class="fas fa-chart-bar mr-2"></i> Lihat Rekap Nilai Siswa
        </a>
    </div>

        @forelse($ujian->soals as $index => $soal)
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-200 relative hover:shadow-md transition">
                <div class="absolute -left-3 -top-3 w-8 h-8 bg-emerald-500 text-white font-bold rounded-full flex items-center justify-center border-4 border-gray-50 shadow-sm">
                    {{ $index + 1 }}
                </div>
                
                <div class="absolute right-4 top-4 flex items-center space-x-3 bg-white px-2 py-1 rounded-lg border border-gray-100 shadow-sm">
                    <a href="/guru/soal/{{ $soal->id }}/edit" class="text-gray-400 hover:text-emerald-500 transition" title="Edit Pertanyaan">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="/guru/soal/{{ $soal->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal ini?');" class="m-0 p-0 flex">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Hapus Pertanyaan"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </div>

                <div class="pl-4 pr-8 mb-4">
                    <p class="text-gray-800 font-medium whitespace-pre-wrap">{{ $soal->pertanyaan }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pl-4">
                    <div class="p-2 rounded border {{ $soal->kunci_jawaban == 'a' ? 'bg-emerald-50 border-emerald-300 font-bold text-emerald-700' : 'bg-gray-50 border-gray-200 text-gray-600' }}">
                        <span class="mr-2 {{ $soal->kunci_jawaban == 'a' ? 'text-emerald-500' : 'text-gray-400' }}">A.</span> {{ $soal->pilihan_a }}
                        @if($soal->kunci_jawaban == 'a') <i class="fas fa-check-circle float-right mt-1"></i> @endif
                    </div>
                    <div class="p-2 rounded border {{ $soal->kunci_jawaban == 'b' ? 'bg-emerald-50 border-emerald-300 font-bold text-emerald-700' : 'bg-gray-50 border-gray-200 text-gray-600' }}">
                        <span class="mr-2 {{ $soal->kunci_jawaban == 'b' ? 'text-emerald-500' : 'text-gray-400' }}">B.</span> {{ $soal->pilihan_b }}
                        @if($soal->kunci_jawaban == 'b') <i class="fas fa-check-circle float-right mt-1"></i> @endif
                    </div>
                    <div class="p-2 rounded border {{ $soal->kunci_jawaban == 'c' ? 'bg-emerald-50 border-emerald-300 font-bold text-emerald-700' : 'bg-gray-50 border-gray-200 text-gray-600' }}">
                        <span class="mr-2 {{ $soal->kunci_jawaban == 'c' ? 'text-emerald-500' : 'text-gray-400' }}">C.</span> {{ $soal->pilihan_c }}
                        @if($soal->kunci_jawaban == 'c') <i class="fas fa-check-circle float-right mt-1"></i> @endif
                    </div>
                    <div class="p-2 rounded border {{ $soal->kunci_jawaban == 'd' ? 'bg-emerald-50 border-emerald-300 font-bold text-emerald-700' : 'bg-gray-50 border-gray-200 text-gray-600' }}">
                        <span class="mr-2 {{ $soal->kunci_jawaban == 'd' ? 'text-emerald-500' : 'text-gray-400' }}">D.</span> {{ $soal->pilihan_d }}
                        @if($soal->kunci_jawaban == 'd') <i class="fas fa-check-circle float-right mt-1"></i> @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-10 text-center mt-4">
                <div class="w-16 h-16 bg-white text-emerald-300 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm text-2xl"><i class="fas fa-box-open"></i></div>
                <h4 class="font-bold text-gray-700 mb-1">Bank Soal Kosong</h4>
                <p class="text-sm text-gray-500">Silakan tambahkan pertanyaan di form sebelah kanan.</p>
            </div>
        @endforelse
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-6">
            <div class="bg-emerald-600 px-5 py-4"><h3 class="font-bold text-white"><i class="fas fa-plus-circle mr-2"></i> Tambah Soal Baru</h3></div>
            <form action="/guru/ujian/{{ $ujian->id }}/soal" method="POST" class="p-5 space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Teks Pertanyaan <span class="text-red-500">*</span></label>
                    <textarea name="pertanyaan" rows="3" required placeholder="Ketik soal di sini..." class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pilihan Jawaban <span class="text-red-500">*</span></label>
                    
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm font-bold text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">A</span>
                        <input type="text" name="pilihan_a" required class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-emerald-500 focus:border-emerald-500 block flex-1 min-w-0 w-full text-sm p-2.5">
                    </div>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm font-bold text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">B</span>
                        <input type="text" name="pilihan_b" required class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-emerald-500 focus:border-emerald-500 block flex-1 min-w-0 w-full text-sm p-2.5">
                    </div>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm font-bold text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">C</span>
                        <input type="text" name="pilihan_c" required class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-emerald-500 focus:border-emerald-500 block flex-1 min-w-0 w-full text-sm p-2.5">
                    </div>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 text-sm font-bold text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">D</span>
                        <input type="text" name="pilihan_d" required class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-emerald-500 focus:border-emerald-500 block flex-1 min-w-0 w-full text-sm p-2.5">
                    </div>
                </div>

                <div class="bg-emerald-50 p-4 rounded-lg border border-emerald-200 mt-4">
                    <label class="block text-sm font-bold text-emerald-800 mb-2">Kunci Jawaban Benar <span class="text-red-500">*</span></label>
                    <select name="kunci_jawaban" required class="w-full p-2.5 border border-emerald-300 rounded-lg text-sm bg-white font-bold text-emerald-700 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 cursor-pointer">
                        <option value="" disabled selected>-- Pilih Kunci Jawaban --</option>
                        <option value="a">Opsi A</option>
                        <option value="b">Opsi B</option>
                        <option value="c">Opsi C</option>
                        <option value="d">Opsi D</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg shadow-md mt-4 transition">
                    Simpan Pertanyaan <i class="fas fa-save ml-1"></i>
                </button>
            </form>
        </div>
    </div>
</div>

@endsection