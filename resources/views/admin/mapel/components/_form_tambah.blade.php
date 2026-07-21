{{-- ================= KIRI: FORM TAMBAH MAPEL ================= --}}
<div class="lg:col-span-1">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 font-bold text-gray-700 flex items-center">
            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center mr-3">
                <i class="fas fa-book-open"></i>
            </div>
            Tambah Mapel Baru
        </div>
        <form action="/admin/mapel" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-600 mb-2">Nama Mata Pelajaran</label>
                <input type="text" name="nama_mapel" value="{{ old('nama_mapel') }}" required placeholder="Contoh: Matematika, IPA..."
                    class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition text-sm @error('nama_mapel') border-red-500 bg-red-50 @enderror">
                @error('nama_mapel') 
                    <span class="text-xs text-red-500 mt-1 flex items-center"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</span> 
                @enderror
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl transition shadow-sm font-bold flex items-center justify-center">
                <i class="fas fa-save mr-2"></i> Simpan Data Mapel
            </button>
        </form>
    </div>
</div>