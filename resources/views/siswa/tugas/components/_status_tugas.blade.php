{{-- Bagian Kanan: Status & Form Pengumpulan Tugas --}}
<div class="space-y-6">
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-8 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-full -mr-12 -mt-12"></div>
        
        <h3 class="text-lg font-black text-gray-800 mb-6 uppercase tracking-tight relative z-10">Status Tugas</h3>
        
        {{-- Alert Notifikasi Internal --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-xs font-bold flex items-center gap-3 animate-bounce">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-xl mb-6 text-xs font-bold flex items-center gap-3">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
            </div>
        @endif

        {{-- KONDISI 1: JIKA SISWA SUDAH MENGUMPULKAN JAWABAN --}}
        @if($jawaban)
            <div class="text-center py-4 relative z-10">
                <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner rotate-3 transition-transform hover:rotate-0">
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
                    <div class="bg-blue-600 rounded-2xl p-5 text-white shadow-lg shadow-blue-100 flex items-center justify-between">
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

            {{-- FITUR REVISI JAWABAN --}}
            @if(\Carbon\Carbon::now()->lte(\Carbon\Carbon::parse($tugas->batas_waktu)) && $jawaban->nilai === null)
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('form-revisi').classList.toggle('hidden')" class="w-full bg-blue-50 hover:bg-blue-100 text-blue-600 font-bold py-3 px-4 rounded-xl border border-blue-200 text-xs transition-colors flex items-center justify-between">
                        <span><i class="fas fa-sync-alt mr-2"></i> Revisi / Ganti File Jawaban</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>

                    <form id="form-revisi" action="/siswa/tugas/{{ $tugas->id }}/kumpul" method="POST" enctype="multipart/form-data" class="space-y-5 mt-4 hidden bg-gray-50 p-5 rounded-2xl border border-gray-200 shadow-inner">
                        @csrf
                        <div class="bg-blue-50 text-blue-600 text-[10px] p-3 rounded-xl mb-4 font-bold">
                            <i class="fas fa-info-circle mr-1"></i> Peringatan: Mengunggah file baru akan menimpa berkas jawaban sebelumnya.
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Upload File Baru</label>
                            <input type="file" name="file_jawaban" required class="block w-full text-xs text-gray-400 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer bg-white rounded-xl border border-gray-200 font-medium">
                            <p class="text-[9px] text-gray-400 mt-2 italic font-medium">* Format: PDF, DOC, ZIP, JPG (Maks 5MB)</p>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Catatan Revisi (Opsional)</label>
                            <textarea name="catatan_siswa" rows="2" class="w-full bg-white border border-gray-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-blue-500 transition-all">{{ $jawaban->catatan_siswa }}</textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-3 rounded-xl shadow-lg shadow-blue-100 transition-all uppercase tracking-widest text-xs">
                            <i class="fas fa-upload mr-1"></i> Upload Ulang Jawaban
                        </button>
                    </form>
                </div>
            @endif

        {{-- KONDISI 2: JIKA BELUM KUMPUL & DEADLINE TELAH LEWAT --}}
        @else
            @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($tugas->batas_waktu)))
                <div class="text-center py-8 relative z-10">
                    <div class="w-20 h-20 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner transition-transform hover:scale-105">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h4 class="font-black text-gray-800 uppercase tracking-widest text-xs mb-2">Akses Ditutup</h4>
                    <div class="bg-red-50 border border-red-100 p-4 rounded-xl inline-block max-w-[90%]">
                        <p class="text-[10px] text-red-600 font-bold leading-relaxed">
                            Maaf, kamu tidak bisa lagi mengirim jawaban.<br>Batas waktu pengumpulan telah berakhir pada:
                        </p>
                        <p class="text-xs text-red-700 font-black mt-1">
                            {{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y, H:i') }} WIB
                        </p>
                    </div>
                </div>

            {{-- KONDISI 3: BELUM KUMPUL & MASIH AKTIF --}}
            @else
                <div class="bg-amber-50 border border-amber-100 p-4 rounded-2xl text-[10px] font-bold text-amber-700 leading-relaxed mb-6">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Jangan sampai terlambat! Unggah file jawabanmu sebelum batas waktu berakhir bray.
                </div>

                <form action="/siswa/tugas/{{ $tugas->id }}/kumpul" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div class="group">
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Upload Jawaban</label>
                        <input type="file" name="file_jawaban" required class="block w-full text-xs text-gray-400 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all cursor-pointer bg-gray-50 rounded-xl border border-gray-100 font-medium">
                        <p class="text-[9px] text-gray-400 mt-2 italic font-medium">* Format: PDF, DOC, ZIP, JPG (Maks 5MB)</p>
                        @error('file_jawaban') <p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-tighter">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Catatan Siswa (Opsional)</label>
                        <textarea name="catatan_siswa" rows="3" class="w-full bg-gray-50 border border-gray-100 rounded-2xl p-4 text-xs font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all shadow-inner" placeholder="Tulis pesan untuk guru jika ada..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-100 transition-all active:scale-95 uppercase tracking-[0.2em] text-xs flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Kirim Jawaban
                    </button>
                </form>
            @endif
        @endif
    </div>
</div>