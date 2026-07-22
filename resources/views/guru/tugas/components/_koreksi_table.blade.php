<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-[10px] font-black uppercase tracking-[0.2em] border-b border-gray-100">
                    <th class="px-6 py-5 text-center w-16">No</th>
                    <th class="px-6 py-5">Identitas Siswa</th>
                    <th class="px-6 py-5 text-center">Status Kehadiran</th>
                    <th class="px-6 py-5">Hasil Pekerjaan</th>
                    <th class="px-6 py-5 bg-slate-50/50">Penilaian Guru</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pengumpulan as $index => $p)
                <tr class="hover:bg-slate-50/50 transition duration-200">
                    <td class="px-6 py-6 text-center font-medium text-gray-400">{{ $index + 1 }}</td>
                    
                    {{-- Kolom Identitas Siswa --}}
                    <td class="px-6 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-11 h-11 rounded-xl bg-blue-100/50 text-blue-600 flex items-center justify-center font-bold text-sm uppercase shrink-0 border border-blue-100">
                                {{ substr($p->nama_siswa, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 text-sm">{{ $p->nama_siswa }}</div>
                                @if($p->tanggal_kumpul)
                                    <div class="text-[10px] text-gray-400 font-medium flex items-center mt-0.5">
                                        <i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($p->tanggal_kumpul)->format('d M, H:i') }}
                                        @if(\Carbon\Carbon::parse($p->tanggal_kumpul) > $tugas->batas_waktu)
                                            <span class="ml-2 text-red-500 font-black tracking-tighter uppercase text-[9px]">Terlambat</span>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-[10px] text-gray-400 italic">Belum menyerahkan</div>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Kolom Status Kehadiran (Absensi) --}}
                    <td class="px-6 py-6 text-center">
                        @if($p->file_jawaban)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-[10px] font-black uppercase tracking-wider">
                                <i class="fas fa-check-circle text-emerald-500"></i> Hadir (Kumpul)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 border border-red-100 rounded-full text-[10px] font-black uppercase tracking-wider">
                                <i class="fas fa-times-circle text-red-500"></i> Belum Kumpul
                            </span>
                        @endif
                    </td>
                    
                    {{-- Kolom Pekerjaan --}}
                    <td class="px-6 py-6">
                        @if($p->file_jawaban)
                            <a href="{{ asset('uploads/tugas/' . $p->file_jawaban) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-blue-600 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm mb-3">
                                <i class="fas fa-file-download text-sm"></i> Download Jawaban
                            </a>
                            @if($p->catatan_siswa)
                                <div class="max-w-xs overflow-hidden">
                                    <div class="text-[10px] font-black text-gray-400 uppercase mb-1">Catatan Siswa:</div>
                                    <p class="text-xs text-gray-600 italic bg-gray-50 p-3 rounded-xl border border-gray-100 line-clamp-2 hover:line-clamp-none transition-all">
                                        "{{ $p->catatan_siswa }}"
                                    </p>
                                </div>
                            @endif
                        @else
                            <span class="text-xs text-gray-400 font-medium italic">- Tidak Ada Berkas -</span>
                        @endif
                    </td>

                    {{-- Kolom Penilaian Guru --}}
                    <td class="px-6 py-6 bg-slate-50/30">
                        @if($p->pengumpulan_id)
                            <form action="/guru/tugas/nilai/{{ $p->pengumpulan_id }}" method="POST" class="space-y-3 min-w-[250px]">
                                @csrf
                                <div class="flex items-center gap-3">
                                    <div class="relative w-24">
                                        <input type="number" name="nilai" min="0" max="100" value="{{ $p->nilai }}" required 
                                            class="w-full p-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-black text-center text-emerald-700 transition" 
                                            placeholder="0">
                                        <span class="absolute -top-2 -right-1 bg-emerald-500 text-white text-[8px] px-1.5 py-0.5 rounded-full font-black">NILAI</span>
                                    </div>
                                    <div class="flex-1">
                                        <textarea name="catatan_guru" rows="1" 
                                            class="w-full p-2.5 bg-white border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition" 
                                            placeholder="Tulis feedback singkat...">{{ $p->catatan_guru }}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="w-full bg-white border border-emerald-200 text-emerald-600 hover:bg-emerald-600 hover:text-white font-black py-2.5 rounded-xl text-[10px] uppercase tracking-[0.2em] transition-all shadow-sm active:scale-95">
                                    <i class="fas fa-check-double mr-1"></i> Simpan Penilaian
                                </button>
                            </form>
                        @else
                            <div class="text-xs text-gray-400 italic">Siswa belum mengumpulkan tugas untuk dinilai.</div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-20 text-center">
                        <div class="w-20 h-20 bg-gray-50 text-gray-200 rounded-3xl flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner">
                            <i class="fas fa-users-slash"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Belum Ada Siswa</h3>
                        <p class="text-gray-500 text-xs mt-1">Belum ada siswa yang terdaftar di rombel/kelas ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>