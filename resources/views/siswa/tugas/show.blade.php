@extends('layouts.app')

@section('content')

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="/siswa/kelas/{{ $tugas->guru_mapel_id }}" class="group inline-flex items-center text-sm font-bold text-gray-400 hover:text-purple-600 transition">
            <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-purple-50 flex items-center justify-center mr-3 transition">
                <i class="fas fa-arrow-left text-xs"></i>
            </div>
            Kembali ke Ruang Kelas
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-10 border-b border-gray-50">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="bg-purple-50 text-purple-600 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest border border-purple-100">Lembar Tugas Esai</span>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-black text-gray-800 tracking-tight mb-6">{{ $tugas->judul }}</h1>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-blue-500">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <span class="block text-[9px] text-gray-400 font-black uppercase tracking-wider">Guru Pengampu</span>
                                <span class="text-sm font-bold text-gray-700">{{ $tugas->guruMapel->user->name ?? 'Guru Mapel' }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 bg-red-50 p-4 rounded-2xl border border-red-100">
                            <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-red-500">
                                <i class="fas fa-hourglass-end"></i>
                            </div>
                            <div>
                                <span class="block text-[9px] text-red-400 font-black uppercase tracking-wider">Batas Pengumpulan</span>
                                <span class="text-sm font-bold text-red-600">{{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M, H:i') }} WIB</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-10">
                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Instruksi Pengerjaan</h4>
                    <div class="prose max-w-none text-gray-600 leading-relaxed font-medium">
                        {!! nl2br(e($tugas->deskripsi)) !!}
                    </div>

                    @if($tugas->file_tugas)
                    <div class="mt-10 p-6 bg-blue-50 rounded-2xl border border-blue-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-blue-600 text-xl">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <div>
                                <h5 class="font-bold text-blue-900 text-sm">Lampiran Soal dari Guru</h5>
                                <p class="text-xs text-blue-600 opacity-70">Silakan download untuk melihat detail soal.</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/tugas/' . $tugas->file_tugas) }}" target="_blank" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-blue-100 flex items-center justify-center gap-2">
                            <i class="fas fa-download"></i> Download File
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-24 h-24 bg-purple-50 rounded-full -mr-12 -mt-12"></div>
                
                <h3 class="text-lg font-black text-gray-800 mb-6 uppercase tracking-tight relative z-10">Status Tugas</h3>
                
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-xs font-bold flex items-center gap-3 animate-bounce">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if($jawaban)
                    <div class="text-center py-4 relative z-10">
                        <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner rotate-3 transition-transform hover:rotate-0">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <h4 class="font-black text-gray-800 uppercase tracking-widest text-xs">Tugas Diserahkan</h4>
                        <p class="text-[10px] text-gray-400 font-bold mt-1 tracking-tighter">{{ $jawaban->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    <div class="mt-6 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                        <span class="block text-[9px] text-gray-400 font-black uppercase mb-2">Dokumen Jawaban</span>
                        <a href="{{ asset('uploads/tugas/' . $jawaban->file_jawaban) }}" target="_blank" class="flex items-center gap-3 text-blue-600 group">
                            <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-xs group-hover:bg-blue-600 group-hover:text-white transition">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <span class="text-xs font-bold truncate group-hover:underline">{{ Str::limit($jawaban->file_jawaban, 20) }}</span>
                        </a>
                    </div>

                    <div class="mt-8 pt-6 border-t border-dashed border-gray-200">
                        <span class="block text-[10px] text-gray-400 font-black uppercase tracking-widest mb-4">Hasil Evaluasi</span>
                        @if($jawaban->nilai !== null)
                            <div class="bg-emerald-600 rounded-2xl p-5 text-white shadow-lg shadow-emerald-100 flex items-center justify-between">
                                <div>
                                    <span class="block text-[9px] font-black opacity-70 uppercase">Skor Perolehan</span>
                                    <span class="text-4xl font-black tracking-tighter">{{ $jawaban->nilai }}</span>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-xl">
                                    <i class="fas fa-award"></i>
                                </div>
                            </div>
                            @if($jawaban->catatan_guru)
                                <div class="mt-4 bg-amber-50 p-4 rounded-2xl border border-amber-100 relative">
                                    <i class="fas fa-quote-left absolute top-2 right-4 text-amber-200 text-2xl"></i>
                                    <span class="block text-[9px] font-black text-amber-600 uppercase mb-1 italic">Catatan Guru:</span>
                                    <p class="text-xs text-amber-800 font-medium leading-relaxed italic">"{{ $jawaban->catatan_guru }}"</p>
                                </div>
                            @endif
                        @else
                            <div class="bg-slate-100 text-slate-400 text-[10px] p-4 rounded-2xl text-center font-black uppercase tracking-widest shadow-inner">
                                <i class="fas fa-clock mr-1"></i> Menunggu Penilaian
                            </div>
                        @endif
                    </div>

                @else
                    <div class="bg-amber-50 border border-amber-100 p-4 rounded-2xl text-[10px] font-bold text-amber-700 leading-relaxed mb-6">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Jangan sampai terlambat! Unggah file jawabanmu sebelum batas waktu berakhir.
                    </div>

                    <form action="/siswa/tugas/{{ $tugas->id }}/kumpul" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <div class="group">
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Upload Jawaban</label>
                            <div class="relative">
                                <input type="file" name="file_jawaban" required class="block w-full text-xs text-gray-400
                                    file:mr-4 file:py-3 file:px-4
                                    file:rounded-xl file:border-0
                                    file:text-[10px] file:font-black file:uppercase file:tracking-widest
                                    file:bg-purple-600 file:text-white
                                    hover:file:bg-purple-700 transition-all cursor-pointer bg-gray-50 rounded-xl border border-gray-100 font-medium">
                            </div>
                            <p class="text-[9px] text-gray-400 mt-2 italic font-medium">* Format: PDF, DOC, ZIP, JPG (Maks 5MB)</p>
                            @error('file_jawaban') <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-tighter">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Catatan Siswa (Opsional)</label>
                            <textarea name="catatan_siswa" rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-2xl p-4 text-xs font-medium focus:ring-2 focus:ring-purple-500 focus:bg-white transition-all shadow-inner" placeholder="Tulis pesan untuk guru jika ada..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-purple-100 transition-all active:scale-95 uppercase tracking-[0.2em] text-xs flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i> Kirim Jawaban
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection