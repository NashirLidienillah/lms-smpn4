<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="bg-gray-50 p-4 border-b border-gray-100 flex flex-col lg:flex-row justify-between gap-4 items-center">
        <div class="flex overflow-x-auto pb-1 w-full lg:w-auto hide-scrollbar gap-2" style="-ms-overflow-style: none; scrollbar-width: none;">
            <button onclick="changeTab('semua')" data-target="semua" class="tab-btn bg-blue-600 text-white shadow-md px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 whitespace-nowrap">
                <i class="fas fa-users mr-1"></i> Semua
            </button>
            <button onclick="changeTab('admin')" data-target="admin" class="tab-btn bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 whitespace-nowrap">
                <i class="fas fa-user-shield mr-1 text-red-500"></i> Admin
            </button>
            <button onclick="changeTab('guru')" data-target="guru" class="tab-btn bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 whitespace-nowrap">
                <i class="fas fa-chalkboard-teacher mr-1 text-blue-500"></i> Guru
            </button>
            <button onclick="changeTab('siswa')" data-target="siswa" class="tab-btn bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 whitespace-nowrap">
                <i class="fas fa-user-graduate mr-1 text-green-500"></i> Siswa
            </button>
        </div>

        <div class="relative w-full lg:w-80">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" id="searchInput" oninput="applyFilters()" class="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 shadow-sm transition" placeholder="Cari nama atau NIS/NIP...">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                    <th class="p-4 font-bold w-16 text-center">No</th>
                    <th class="p-4 font-bold">Profil Pengguna</th>
                    <th class="p-4 font-bold">Username / ID</th>
                    <th class="p-4 font-bold text-center">Role</th>
                    <th class="p-4 font-bold text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody id="userTableBody" class="divide-y divide-gray-50">
                @foreach($users as $index => $user)
                
                @php
                    $infoKelas = 'Tidak Berlaku (Bukan Siswa)';
                    $isBelumMasukKelas = false;

                    if($user->role === 'siswa') {
                        $tahunAktif = \App\Models\TahunAkademik::where('status_aktif', 1)->first(); 
                        if($tahunAktif) {
                            $rombel = \App\Models\Rombel::where('user_id', $user->id)->where('tahun_akademik_id', $tahunAktif->id)->first();
                            if($rombel) {
                                $infoKelas = 'Kelas ' . $rombel->kelas->nama_kelas;
                            } else {
                                $infoKelas = 'Belum memiliki kelas di periode ini.';
                                $isBelumMasukKelas = true;
                            }
                        } else {
                            $infoKelas = 'Tahun akademik belum diatur.';
                            $isBelumMasukKelas = true;
                        }
                    }
                @endphp

                <tr class="user-row hover:bg-slate-50 transition duration-200" data-role="{{ $user->role }}">
                    <td class="p-4 text-center font-medium text-gray-400 serial-number">{{ $index + 1 }}</td>
                    
                    <td class="p-4 searchable-data">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100/50 text-blue-600 border border-blue-200/50 flex items-center justify-center font-bold text-sm uppercase shrink-0">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 text-sm">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">Terdaftar: {{ $user->created_at->format('M Y') }}</div>
                            </div>
                        </div>
                    </td>
                    
                    <td class="p-4">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-gray-100 text-gray-600 font-mono text-xs searchable-data">
                            <i class="fas fa-id-card text-gray-400"></i> {{ $user->username }}
                        </div>
                    </td>
                    
                    <td class="p-4 text-center">
                        @if($user->role === 'admin')
                            <span class="bg-red-50 text-red-600 border border-red-200 px-3 py-1 rounded-lg text-xs font-bold"><i class="fas fa-shield-alt mr-1"></i> Admin</span>
                        @elseif($user->role === 'guru')
                            <span class="bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1 rounded-lg text-xs font-bold"><i class="fas fa-chalkboard-teacher mr-1"></i> Guru</span>
                        @else
                            <span class="bg-blue-50 text-blue-600 border border-blue-200 px-3 py-1 rounded-lg text-xs font-bold"><i class="fas fa-user-graduate mr-1"></i> Siswa</span>
                        @endif
                    </td>
                    
                    <td class="p-4 text-center">
                        <div class="flex justify-center items-center gap-2">
                            <button type="button" onclick="openDetailModal('{{ addslashes($user->name) }}', '{{ $user->username }}', '{{ $user->role }}', '{{ $infoKelas }}', {{ $isBelumMasukKelas ? 'true' : 'false' }})" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-teal-100 text-gray-500 hover:text-teal-600 flex items-center justify-center transition" title="Lihat Detail Profil">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                            <a href="/admin/users/{{ $user->id }}/edit" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-blue-100 text-gray-500 hover:text-blue-600 flex items-center justify-center transition" title="Edit">
                                <i class="fas fa-pen text-sm"></i>
                            </a>
                            <form id="delete-user-form-{{ $user->id }}" action="/admin/users/{{ $user->id }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="openDeleteModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->role }}')" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-red-100 text-gray-500 hover:text-red-600 flex items-center justify-center transition" title="Hapus Pengguna">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

                <tr id="empty-state" style="display: none;">
                    <td colspan="5" class="p-16 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Tidak ada pengguna ditemukan</h3>
                        <p class="text-gray-500 text-sm mt-1">Coba sesuaikan kata kunci pencarian atau filter tab.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>