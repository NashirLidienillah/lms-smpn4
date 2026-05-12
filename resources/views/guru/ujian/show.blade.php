@extends('layouts.app')

@section('content')

{{-- ================= NOTIFIKASI TOAST (BENTO STYLE) ================= --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-2xl shadow-xl border-l-4 border-emerald-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-emerald-500 bg-emerald-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

<div class="mb-6">
    <a href="/guru/kelas/{{ $ujian->guru_mapel_id }}" class="group inline-flex items-center text-sm font-bold text-gray-400 hover:text-emerald-600 transition">
        <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-emerald-50 flex items-center justify-center mr-3 transition">
            <i class="fas fa-arrow-left text-xs"></i>
        </div>
        Kembali ke Ruang Kelas
    </a>
</div>

<div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center relative overflow-hidden">
    <div class="absolute left-0 top-0 h-full w-2 bg-emerald-600"></div>
    <div class="relative z-10">
        <div class="flex items-center gap-3 mb-2">
            <span class="bg-emerald-50 text-emerald-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-emerald-100">Dapur Ujian CBT</span>
            <span class="text-gray-300">•</span>
            <span class="text-xs font-bold text-gray-400"><i class="fas fa-stopwatch mr-1"></i> {{ $ujian->durasi }} Menit</span>
        </div>
        <h2 class="text-3xl font-black text-gray-800 tracking-tight">{{ $ujian->judul }}</h2>
        <p class="text-gray-500 text-sm mt-1 font-medium">Pastikan semua kunci jawaban sudah benar sebelum dibagikan ke siswa.</p>
    </div>
    
    <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex-1">
            <span class="block text-[9px] text-gray-400 font-black uppercase tracking-wider mb-2">Periode Akses</span>
            <div class="space-y-1.5">
                <div class="flex items-center gap-2 text-xs font-bold text-gray-700">
                    <i class="fas fa-door-open text-emerald-500 w-4"></i> {{ $ujian->mulai->format('d M, H:i') }}
                </div>
                <div class="flex items-center gap-2 text-xs font-bold text-gray-700">
                    <i class="fas fa-door-closed text-red-500 w-4"></i> {{ $ujian->selesai->format('d M, H:i') }}
                </div>
            </div>
        </div>
        <div class="bg-emerald-600 p-4 rounded-2xl text-white flex flex-col justify-center items-center px-8 shadow-lg shadow-emerald-100 flex-1">
            <span class="text-[9px] font-black uppercase tracking-widest opacity-70">Total Soal</span>
            <span class="text-3xl font-black">{{ count($ujian->soals) }}</span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2 space-y-6">
        <div class="flex justify-between items-center px-2">
            <h3 class="font-black text-gray-800 text-lg uppercase tracking-tight flex items-center gap-3">
                <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center text-sm">
                    <i class="fas fa-list-ul"></i>
                </div>
                Bank Pertanyaan
            </h3>
            
            <a href="/guru/ujian/{{ $ujian->id }}/rekap" class="bg-white border border-blue-200 text-blue-600 hover:bg-blue-600 hover:text-white text-[10px] font-black px-4 py-2.5 rounded-xl uppercase tracking-widest transition shadow-sm flex items-center gap-2">
                <i class="fas fa-chart-pie"></i> Rekap Nilai
            </a>
        </div>

        @forelse($ujian->soals as $index => $soal)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative group transition-all duration-300 hover:shadow-xl">
                <div class="absolute -left-3 top-6 w-10 h-10 bg-emerald-600 text-white font-black rounded-xl flex items-center justify-center border-4 border-white shadow-lg group-hover:scale-110 transition-transform">
                    {{ $index + 1 }}
                </div>
                
                <div class="absolute right-6 top-6 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="/guru/soal/{{ $soal->id }}/edit" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 hover:bg-emerald-600 hover:text-white transition shadow-sm">
                        <i class="fas fa-pen text-[10px]"></i>
                    </a>
                    <form action="/guru/soal/{{ $soal->id }}" method="POST" onsubmit="return confirm('Hapus soal ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center border border-red-100 hover:bg-red-600 hover:text-white transition shadow-sm">
                            <i class="fas fa-trash-alt text-[10px]"></i>
                        </button>
                    </form>
                </div>

                <div class="pl-8 pt-2">
                    <div class="mb-6">
                        <p class="text-gray-800 font-bold leading-relaxed whitespace-pre-wrap">{{ $soal->pertanyaan }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach(['a', 'b', 'c', 'd'] as $opsi)
                            @php 
                                $isCorrect = ($soal->kunci_jawaban == $opsi);
                                $pilihanText = $soal->{'pilihan_' . $opsi};
                            @endphp
                            <div class="p-4 rounded-2xl border transition-all duration-300 flex items-center gap-3 {{ $isCorrect ? 'bg-emerald-50 border-emerald-200 ring-2 ring-emerald-500/20' : 'bg-gray-50 border-gray-100 grayscale-[0.5] opacity-70' }}">
                                <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[10px] font-black uppercase shrink-0 {{ $isCorrect ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                                    {{ $opsi }}
                                </div>
                                <span class="text-xs font-bold {{ $isCorrect ? 'text-emerald-900' : 'text-gray-600' }}">{{ $pilihanText }}</span>
                                @if($isCorrect)
                                    <i class="fas fa-check-circle text-emerald-600 ml-auto"></i>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-3xl p-16 text-center">
                <div class="w-20 h-20 bg-white text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-3xl"><i class="fas fa-file-medical"></i></div>
                <h4 class="font-bold text-gray-400">Belum ada pertanyaan di bank soal.</h4>
            </div>
        @endforelse
    </div>

    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
            <div class="bg-emerald-600 px-6 py-5 flex items-center gap-3">
                <i class="fas fa-plus-circle text-white text-xl"></i>
                <h3 class="font-bold text-white uppercase tracking-wider text-sm">Tambah Soal</h3>
            </div>
            
            <form action="/guru/ujian/{{ $ujian->id }}/soal" method="POST" class="p-6 space-y-5">
                @csrf
                
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Teks Pertanyaan</label>
                    <textarea name="pertanyaan" rows="4" required placeholder="Tuliskan butir soal di sini..." class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white transition leading-relaxed"></textarea>
                </div>

                <div class="space-y-3">
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Opsi Jawaban</label>
                    
                    @foreach(['A', 'B', 'C', 'D'] as $label)
                    <div class="group flex">
                        <span class="inline-flex items-center px-4 text-xs font-black text-gray-400 bg-gray-100 border border-r-0 border-gray-200 rounded-l-xl group-focus-within:bg-emerald-600 group-focus-within:text-white group-focus-within:border-emerald-600 transition-all">{{ $label }}</span>
                        <input type="text" name="pilihan_{{ strtolower($label) }}" required placeholder="Pilihan {{ $label }}..." class="w-full p-3 bg-gray-50 border border-gray-200 rounded-r-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:bg-white transition">
                    </div>
                    @endforeach
                </div>

                <div class="p-5 bg-emerald-50/50 border border-emerald-100 rounded-2xl mt-4">
                    <label class="block text-xs font-black text-emerald-800 uppercase tracking-widest mb-3">Kunci Jawaban Benar</label>
                    <select name="kunci_jawaban" required class="w-full p-3 bg-white border border-emerald-200 rounded-xl text-sm font-black text-emerald-700 shadow-sm focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                        <option value="" disabled selected>-- Pilih Kunci --</option>
                        <option value="a">Opsi A</option>
                        <option value="b">Opsi B</option>
                        <option value="c">Opsi C</option>
                        <option value="d">Opsi D</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-emerald-100 transition-all active:scale-95 uppercase tracking-widest text-xs">
                    Simpan Pertanyaan <i class="fas fa-save ml-2"></i>
                </button>
            </form>
        </div>
    </div>
</div>

@endsection