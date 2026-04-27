@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <a href="/guru/kelas/{{ $materi->guru_mapel_id }}" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 transition mb-4 font-medium">
        <i class="fas fa-arrow-left mr-2"></i> Batal & Kembali
    </a>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-blue-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white"><i class="fas fa-edit mr-2"></i> Edit Materi Pembelajaran</h2>
        </div>
        
        <form action="/guru/materi/{{ $materi->id }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            @method('PUT') <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Materi <span class="text-red-500">*</span></label>
                <input type="text" name="judul" value="{{ $materi->judul }}" required class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3" class="w-full p-2.5 border border-gray-300 rounded-lg text-sm bg-gray-50 focus:ring-blue-500 focus:border-blue-500">{{ $materi->deskripsi }}</textarea>
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Materi</label>
                <select name="tipe" id="tipe_materi" onchange="toggleTipeInputEdit()" required class="w-full p-2.5 border border-gray-300 rounded-lg text-sm font-medium text-blue-700 cursor-pointer">
                    <option value="file" {{ $materi->tipe == 'file' ? 'selected' : '' }}>📄 Upload Dokumen (PDF, Word, PPT)</option>
                    <option value="youtube" {{ $materi->tipe == 'youtube' ? 'selected' : '' }}>📺 Link Video YouTube</option>
                </select>
            </div>

            <div id="box_file_edit" class="bg-orange-50 border border-orange-200 p-4 rounded-lg {{ $materi->tipe == 'youtube' ? 'hidden' : '' }}">
                <label class="block text-sm font-bold text-orange-700 mb-2">Ganti File (Kosongkan jika tidak ingin mengubah file lama)</label>
                @if($materi->tipe == 'file' && $materi->file_path)
                    <p class="text-sm text-gray-600 mb-3"><i class="fas fa-paperclip mr-1"></i> File saat ini: <span class="font-semibold text-orange-600">{{ $materi->file_path }}</span></p>
                @endif
                <input type="file" name="file_materi" accept=".pdf,.doc,.docx,.ppt,.pptx" class="w-full text-sm text-gray-500 bg-white border border-orange-200 rounded p-1">
            </div>

            <div id="box_youtube_edit" class="bg-red-50 border border-red-200 p-4 rounded-lg {{ $materi->tipe == 'file' ? 'hidden' : '' }}">
                <label class="block text-sm font-bold text-red-700 mb-2">URL YouTube Baru</label>
                <input type="url" name="url_youtube" value="{{ $materi->url_youtube }}" class="w-full p-2.5 border border-red-300 rounded-lg text-sm bg-white focus:ring-red-500 focus:border-red-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-md mt-4 transition">
                Simpan Perubahan <i class="fas fa-save ml-1"></i>
            </button>
        </form>
    </div>
</div>

<script>
    function toggleTipeInputEdit() {
        const tipe = document.getElementById('tipe_materi').value;
        if (tipe === 'file') {
            document.getElementById('box_file_edit').classList.remove('hidden');
            document.getElementById('box_youtube_edit').classList.add('hidden');
        } else {
            document.getElementById('box_youtube_edit').classList.remove('hidden');
            document.getElementById('box_file_edit').classList.add('hidden');
        }
    }
</script>
@endsection