{{-- KOLOM TABEL DATA --}}
<div class="lg:col-span-2">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <span class="font-bold text-gray-700">Daftar Tahun Akademik</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                        <th class="p-4 font-bold w-12 text-center">No</th>
                        <th class="p-4 font-bold">Periode Belajar</th>
                        <th class="p-4 font-bold text-center">Status</th>
                        <th class="p-4 font-bold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($tahun as $index => $t)
                    
                    <tr class="transition duration-200 group {{ $t->status_aktif ? 'bg-indigo-50/40 hover:bg-indigo-50' : 'hover:bg-slate-50' }}">
                        <td class="p-4 text-center font-medium text-gray-400">{{ $index + 1 }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl {{ $t->status_aktif ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center font-bold shrink-0 transition-all">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <div class="font-bold {{ $t->status_aktif ? 'text-indigo-900' : 'text-gray-800' }} text-base">{{ $t->nama_tahun }}</div>
                                    <div class="text-xs {{ $t->status_aktif ? 'text-indigo-600 font-medium' : 'text-gray-400' }} mt-0.5 uppercase tracking-wide">Semester {{ $t->semester }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            @if($t->status_aktif)
                                <span class="inline-flex items-center gap-1.5 bg-green-100 text-green-700 border border-green-200 px-3 py-1 rounded-lg text-xs font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> SEDANG AKTIF
                                </span>
                            @else
                                <span class="inline-flex items-center bg-gray-100 text-gray-500 px-3 py-1 rounded-lg text-xs font-semibold">
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center items-center gap-2">
                                @if(!$t->status_aktif)
                                    <form id="activate-form-{{ $t->id }}" action="/admin/tahun-akademik/{{ $t->id }}/aktif" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" onclick="openActivateModal({{ $t->id }}, '{{ $t->nama_tahun }} - Semester {{ $t->semester }}')" class="w-9 h-9 rounded-lg bg-gray-50 hover:bg-green-100 text-gray-400 hover:text-green-600 flex items-center justify-center transition" title="Jadikan Periode Aktif">
                                            <i class="fas fa-power-off text-sm"></i>
                                        </button>
                                    </form>
                                @else
                                    <div class="w-9 h-9 flex items-center justify-center text-green-500" title="Ini adalah periode aktif">
                                        <i class="fas fa-check-circle text-lg"></i>
                                    </div>
                                @endif

                                <form id="delete-form-{{ $t->id }}" action="/admin/tahun-akademik/{{ $t->id }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="openDeleteModal({{ $t->id }}, '{{ $t->nama_tahun }} - Semester {{ $t->semester }}')" class="w-9 h-9 rounded-lg bg-gray-50 hover:bg-red-100 text-gray-400 hover:text-red-600 flex items-center justify-center transition" title="Hapus Periode">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Belum ada pengaturan</h3>
                            <p class="text-gray-500 text-sm mt-1">Silakan buat tahun akademik baru agar sistem bisa berjalan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>