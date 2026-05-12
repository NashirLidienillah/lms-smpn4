@extends('layouts.app')

@section('content')

{{-- ================= NOTIFIKASI TOAST MELAYANG ================= --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-xl shadow-xl border-l-4 border-green-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row items-start md:items-center justify-between relative overflow-hidden">
        <div class="absolute left-0 top-0 w-1.5 h-full bg-blue-600"></div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Jadwal Pelajaran</h2>
            <p class="text-sm text-gray-500 mt-1">Mengatur jadwal mengajar guru pada tahun ajaran aktif.</p>
        </div>
        <div class="mt-4 md:mt-0 text-left md:text-right w-full md:w-auto">
            <span class="block text-xs text-gray-400 mb-1 uppercase tracking-wider font-bold">Tahun Akademik Aktif</span>
            <span class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-2 rounded-xl text-sm font-bold inline-flex items-center w-full md:w-auto justify-center">
                <i class="fas fa-calendar-check mr-2"></i> {{ $tahunAktif->nama_tahun }} ({{ $tahunAktif->semester }})
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 font-bold text-gray-700 flex items-center">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                        <i class="fas fa-clock"></i>
                    </div>
                    Buat Jadwal Baru
                </div>
                <form action="/admin/guru-mapel" method="POST" class="p-6 space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-1.5">Pilih Kelas</label>
                        <select name="kelas_id" required class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">Kelas {{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-1.5">Mata Pelajaran</label>
                        <select name="mapel_id" required class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-1.5">Guru Pengajar</label>
                        <select name="user_id" required class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">-- Pilih Guru --</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Hari</label>
                            <select name="hari" required class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Jam Mulai</label>
                                <input type="time" name="jam_mulai" required class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Jam Selesai</label>
                                <input type="time" name="jam_selesai" required class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl transition shadow-sm font-bold flex items-center justify-center">
                        <i class="fas fa-plus-circle mr-2"></i> Tambahkan Jadwal
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <span class="font-bold text-gray-700">Daftar Jadwal Mengajar</span>
                    <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">{{ $guruMapels->count() }} Jadwal</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-white text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                                <th class="p-4 font-bold w-12 text-center">No</th>
                                <th class="p-4 font-bold">Waktu & Hari</th>
                                <th class="p-4 font-bold">Kelas & Mapel</th>
                                <th class="p-4 font-bold">Guru Pengajar</th>
                                <th class="p-4 font-bold text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($guruMapels as $index => $gm)
                            <tr class="hover:bg-slate-50 transition duration-200">
                                <td class="p-4 text-center font-medium text-gray-400">{{ $index + 1 }}</td>
                                <td class="p-4">
                                    <div class="font-bold text-blue-600">{{ $gm->hari }}</div>
                                    <div class="text-xs text-gray-500 flex items-center mt-0.5">
                                        <i class="far fa-clock mr-1"></i> {{ substr($gm->jam_mulai, 0, 5) }} - {{ substr($gm->jam_selesai, 0, 5) }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded text-[10px] font-bold border border-slate-200">KELAS {{ $gm->kelas->nama_kelas }}</span>
                                    </div>
                                    <div class="font-bold text-gray-800 text-sm">{{ $gm->mapel->nama_mapel }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-[10px] font-bold border border-emerald-100 shrink-0">
                                            {{ substr($gm->user->name, 0, 1) }}
                                        </div>
                                        <div class="text-sm font-medium text-gray-600">{{ $gm->user->name }}</div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <form id="delete-form-{{ $gm->id }}" action="/admin/guru-mapel/{{ $gm->id }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="openDeleteModal({{ $gm->id }}, '{{ addslashes($gm->user->name) }}', '{{ addslashes($gm->mapel->nama_mapel) }}')" class="w-9 h-9 rounded-lg bg-gray-50 hover:bg-red-100 text-gray-400 hover:text-red-600 flex items-center justify-center transition" title="Hapus Jadwal">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-16 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-300 mb-4 text-3xl">
                                        <i class="fas fa-calendar-times"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">Jadwal Masih Kosong</h3>
                                    <p class="text-gray-500 text-sm mt-1">Gunakan form di samping untuk mulai membagi jadwal mengajar.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 px-4">
    <div id="deleteModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300 relative overflow-hidden">
        
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-red-50 rounded-full blur-2xl"></div>

        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 text-red-600 rounded-full mb-4 border-4 border-white shadow-sm relative z-10">
            <i class="fas fa-calendar-times text-2xl"></i>
        </div>
        
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2 relative z-10">Hapus Jadwal?</h3>
        <p class="text-center text-gray-500 text-sm mb-6 relative z-10 leading-relaxed">
            Yakin ingin menghapus jadwal mengajar <br> <span id="detailTugasLabel" class="font-bold text-gray-800"></span>?
        </p>
        
        <div class="flex space-x-3 relative z-10">
            <button onclick="closeDeleteModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded-xl transition shadow-sm">
                Batal
            </button>
            <button onclick="submitDeleteForm()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl shadow-sm transition">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    let currentDeleteId = null;
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const detailTugasLabel = document.getElementById('detailTugasLabel');

    function openDeleteModal(id, namaGuru, namaMapel) {
        currentDeleteId = id;
        detailTugasLabel.innerText = namaGuru + ' - ' + namaMapel; 
        deleteModal.classList.remove('hidden');
        setTimeout(() => {
            deleteModal.classList.remove('opacity-0');
            deleteModalContent.classList.remove('scale-95');
            deleteModalContent.classList.add('scale-100');
        }, 10);
    }

    function closeDeleteModal() {
        deleteModal.classList.add('opacity-0');
        deleteModalContent.classList.remove('scale-100');
        deleteModalContent.classList.add('scale-95');
        setTimeout(() => { deleteModal.classList.add('hidden'); currentDeleteId = null; }, 300);
    }

    function submitDeleteForm() {
        if (currentDeleteId) { document.getElementById('delete-form-' + currentDeleteId).submit(); }
    }
</script>

@endsection