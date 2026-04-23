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

@if(session('error'))
    <div id="toast-error" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-lg shadow-xl border-l-4 border-red-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg"><i class="fas fa-exclamation"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('error') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-error').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-error')?.remove(); }, 4000);</script>
@endif

{{-- Header dengan Indikator Tahun Akademik --}}
<div class="mb-6 bg-white border border-gray-200 rounded-xl p-5 flex flex-col md:flex-row items-start md:items-center justify-between shadow-sm relative overflow-hidden">
    <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-600"></div>
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Jadwal Pelajaran</h2>
        <p class="text-sm text-gray-500 mt-1">Mengatur jadwal mengajar guru pada tahun ajaran aktif.</p>
    </div>
    <div class="mt-4 md:mt-0 text-left md:text-right">
        <span class="block text-xs text-gray-400 mb-1 uppercase tracking-wider font-bold">Tahun Akademik Aktif</span>
        <span class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-2 rounded-lg text-sm font-bold shadow-sm inline-block">
            <i class="fas fa-calendar-check mr-2"></i> {{ $tahunAktif->nama_tahun }} (Semester {{ $tahunAktif->semester }})
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b font-semibold text-gray-700">
                <i class="fas fa-calendar-plus mr-2 text-blue-600"></i> Buat Jadwal Baru
            </div>
            <form action="/admin/guru-mapel" method="POST" class="p-4 space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kelas</label>
                    <select name="kelas_id" required class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Mata Pelajaran</label>
                    <select name="mapel_id" required class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50">
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Guru</label>
                    <select name="user_id" required class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3 bg-gray-50 p-3 rounded border border-gray-200">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                        <select name="hari" required class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="Senin">Senin</option>
                            <option value="Selasa">Selasa</option>
                            <option value="Rabu">Rabu</option>
                            <option value="Kamis">Kamis</option>
                            <option value="Jumat">Jumat</option>
                            <option value="Sabtu">Sabtu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                        <input type="time" name="jam_mulai" required class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                        <input type="time" name="jam_selesai" required class="w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    @error('jam_selesai') <span class="col-span-2 text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded transition shadow-sm font-medium mt-2">
                    <i class="fas fa-save mr-1"></i> Simpan Jadwal
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 text-sm border-b">
                        <th class="p-4 font-semibold w-12 text-center">No</th>
                        <th class="p-4 font-semibold">Waktu (Hari & Jam)</th>
                        <th class="p-4 font-semibold">Kelas</th>
                        <th class="p-4 font-semibold">Mata Pelajaran</th>
                        <th class="p-4 font-semibold">Guru</th>
                        <th class="p-4 font-semibold text-center w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guruMapels as $index => $gm)
                    <tr class="border-b hover:bg-gray-50 transition text-sm text-gray-800">
                        <td class="p-4 text-center">{{ $index + 1 }}</td>
                        <td class="p-4">
                            <span class="font-bold text-blue-700">{{ $gm->hari }}</span><br>
                            <span class="text-xs text-gray-500">{{ substr($gm->jam_mulai, 0, 5) }} - {{ substr($gm->jam_selesai, 0, 5) }}</span>
                        </td>
                        <td class="p-4"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">{{ $gm->kelas->nama_kelas }}</span></td>
                        <td class="p-4 font-medium">{{ $gm->mapel->nama_mapel }}</td>
                        <td class="p-4 text-gray-600">{{ $gm->user->name }}</td>
                        <td class="p-4 text-center">
                            <form id="delete-form-{{ $gm->id }}" action="/admin/guru-mapel/{{ $gm->id }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="openDeleteModal({{ $gm->id }}, '{{ $gm->user->name }}', '{{ $gm->mapel->nama_mapel }}')" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded transition" title="Hapus Data">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mb-3 text-2xl">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <p class="text-gray-500 italic">Belum ada jadwal pelajaran di tahun akademik ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ================= MODAL KONFIRMASI HAPUS ================= --}}
<div id="deleteModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div id="deleteModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300">
        
        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-50 text-red-500 rounded-full mb-4 border-4 border-red-100">
            <i class="fas fa-exclamation-triangle text-2xl"></i>
        </div>
        
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2">Konfirmasi Hapus</h3>
        <p class="text-center text-gray-500 text-sm mb-6">
            Apakah Anda yakin ingin menghapus jadwal mengajar <span id="detailTugasLabel" class="font-bold text-gray-700"></span>?
        </p>
        
        <div class="flex space-x-3">
            <button onclick="closeDeleteModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl transition">
                Batal
            </button>
            <button onclick="submitDeleteForm()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl shadow-md hover:shadow-lg transition">
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
        detailTugasLabel.innerText = namaGuru + ' (' + namaMapel + ')'; 
        
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
        setTimeout(() => {
            deleteModal.classList.add('hidden');
            currentDeleteId = null;
        }, 300);
    }

    function submitDeleteForm() {
        if (currentDeleteId) {
            document.getElementById('delete-form-' + currentDeleteId).submit();
        }
    }
</script>
{{-- ================================================================================= --}}

@endsection