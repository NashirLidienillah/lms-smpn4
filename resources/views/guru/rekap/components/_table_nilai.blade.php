{{-- TABEL NILAI --}}
<div class="overflow-x-auto rounded-2xl border border-gray-100 print:border-none shadow-inner print:shadow-none">
    <table class="min-w-full text-left text-sm whitespace-nowrap print:border-collapse">
        <thead class="bg-slate-50 print:bg-transparent border-b border-gray-200 print:border-black">
            <tr>
                <th scope="col" class="px-5 py-4 border-r border-gray-100 print:border-black w-12 text-center text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest">No</th>
                <th scope="col" class="px-6 py-4 border-r border-gray-100 print:border-black text-[10px] font-black text-gray-400 print:text-black uppercase tracking-widest">Nama Lengkap Siswa</th>
                
                {{-- Loop Header Tugas Esai --}}
                @foreach($listTugas as $tugas)
                    <th scope="col" class="px-4 py-4 border-r border-gray-100 print:border-black text-center bg-purple-50/50 print:bg-transparent text-purple-700 print:text-black" title="{{ $tugas->judul }}">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-file-alt mb-1 text-sm print:hidden opacity-70"></i>
                            <span class="text-[10px] font-black uppercase tracking-wider truncate w-24 inline-block">{{ $tugas->judul }}</span>
                        </div>
                    </th>
                @endforeach

                {{-- Loop Header Ujian CBT --}}
                @foreach($listUjian as $ujian)
                    <th scope="col" class="px-4 py-4 border-r border-gray-100 print:border-black text-center bg-emerald-50/50 print:bg-transparent text-emerald-700 print:text-black" title="{{ $ujian->judul }}">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-laptop-code mb-1 text-sm print:hidden opacity-70"></i>
                            <span class="text-[10px] font-black uppercase tracking-wider truncate w-24 inline-block">{{ $ujian->judul }}</span>
                        </div>
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 print:divide-y-0">
            @forelse($rekapSiswa as $index => $row)
                <tr class="hover:bg-blue-50/40 transition-colors group print:hover:bg-transparent">
                    <td class="px-5 py-4 border-r border-gray-100 print:border-black text-center font-medium text-gray-400 print:text-black">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 border-r border-gray-100 print:border-black">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 font-bold text-xs uppercase flex items-center justify-center shrink-0 print:hidden group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                {{ substr($row['nama'], 0, 1) }}
                            </div>
                            <div class="font-bold text-gray-800 print:text-black text-sm">
                                {{ $row['nama'] }}
                            </div>
                        </div>
                    </td>

                    {{-- Loop Nilai Tugas Siswa Ini --}}
                    @foreach($listTugas as $tugas)
                        @php $nilaiT = $row['nilai_tugas'][$tugas->id]; @endphp
                        <td class="px-4 py-4 border-r border-gray-100 print:border-black text-center font-mono font-black text-sm print:text-black {{ $nilaiT === '-' ? 'text-gray-300' : ($nilaiT < 70 ? 'text-red-500' : 'text-purple-600') }}">
                            <span class="{{ $nilaiT !== '-' && $nilaiT >= 70 ? 'bg-purple-50 print:bg-transparent px-2 py-1 rounded' : '' }}">{{ $nilaiT }}</span>
                        </td>
                    @endforeach

                    {{-- Loop Nilai Ujian Siswa Ini --}}
                    @foreach($listUjian as $ujian)
                        @php $nilaiU = $row['nilai_ujian'][$ujian->id]; @endphp
                        <td class="px-4 py-4 border-r border-gray-100 print:border-black text-center font-mono font-black text-sm print:text-black {{ $nilaiU === '-' ? 'text-gray-300' : ($nilaiU < 70 ? 'text-red-500' : 'text-emerald-600') }}">
                            <span class="{{ $nilaiU !== '-' && $nilaiU >= 70 ? 'bg-emerald-50 print:bg-transparent px-2 py-1 rounded' : '' }}">{{ $nilaiU }}</span>
                        </td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="100" class="px-6 py-16 text-center text-gray-400 print:text-black font-bold border-none border-b print:border-black">
                        <div class="w-16 h-16 bg-gray-50 text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner print:hidden"><i class="fas fa-users-slash"></i></div>
                        Belum ada siswa yang terdaftar di kelas ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>