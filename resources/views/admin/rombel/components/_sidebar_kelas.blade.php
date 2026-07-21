{{-- ================= KIRI: FOLDER KELAS ================= --}}
<div class="lg:col-span-1">
    <div class="sticky top-6 space-y-3">
        <div class="bg-white px-5 py-4 rounded-2xl border border-gray-100 shadow-sm font-bold text-gray-700 flex items-center">
            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                <i class="fas fa-layer-group"></i>
            </div>
            Tingkat Kelas
        </div>

        @php
            $groupedKelas = $kelas->groupBy(function($item) {
                preg_match('/\d+/', $item->nama_kelas, $matches);
                return $matches[0] ?? 'Lainnya';
            });
        @endphp

        @forelse($groupedKelas as $tingkat => $kelasGroup)
            <details class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" {{ (request('kelas_id') && $kelasGroup->contains('id', request('kelas_id'))) ? 'open' : '' }}>
                <summary class="bg-gray-50 text-gray-800 p-4 font-bold text-sm cursor-pointer list-none flex justify-between items-center hover:bg-gray-100 transition select-none">
                    <span class="flex items-center"><i class="fas fa-folder text-yellow-400 mr-3 text-lg drop-shadow-sm"></i> Tingkat {{ $tingkat }}</span>
                    <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300 group-open:rotate-180"></i>
                </summary>
                
                <div class="bg-white border-t border-gray-100 divide-y divide-gray-50">
                    @foreach($kelasGroup as $k)
                        <a href="/admin/rombel?kelas_id={{ $k->id }}" 
                           class="flex items-center p-4 transition text-sm font-medium
                           {{ request('kelas_id') == $k->id ? 'bg-blue-50/50 text-blue-700 border-l-4 border-l-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600 border-l-4 border-transparent' }}">
                            <i class="fas fa-door-open mr-3 {{ request('kelas_id') == $k->id ? 'text-blue-500' : 'text-gray-300' }}"></i> 
                            Kelas {{ $k->nama_kelas }}
                        </a>
                    @endforeach
                </div>
            </details>
        @empty
            <div class="p-8 text-center text-gray-400 text-sm bg-white rounded-2xl border border-gray-100 border-dashed">
                <i class="fas fa-folder-open text-3xl mb-2 text-gray-300"></i><br>
                Belum ada Master Kelas.
            </div>
        @endforelse
    </div>
</div>