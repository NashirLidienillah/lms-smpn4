@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <a href="javascript:history.back()" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 transition mb-2 font-medium">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800">Koreksi Tugas: {{ $tugas->judul }}</h1>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-blue-50 border-b border-blue-100">
            <tr>
                <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase">Nama Siswa</th>
                <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase">File & Catatan</th>
                <th class="px-6 py-4 text-xs font-bold text-blue-800 uppercase w-1/3">Penilaian</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($pengumpulan as $p)
                <tr class="hover:bg-gray-50 transition">
                    <!-- Kolom Siswa -->
                    <td class="px-6 py-4 align-top">
                        <div class="font-bold text-gray-800">{{ $p->siswa->name }}</div>
                        <div class="text-xs text-gray-500 mt-1"><i class="far fa-clock"></i> {{ $p->created_at->format('d M Y, H:i') }}</div>
                    </td>
                    
                    <!-- Kolom Jawaban -->
                    <td class="px-6 py-4 align-top">
                        <a href="{{ asset('uploads/tugas/' . $p->file_jawaban) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md text-sm font-semibold hover:bg-blue-200 transition mb-2">
                            <i class="fas fa-download mr-2"></i> {{ Str::limit($p->file_jawaban, 20) }}
                        </a>
                        @if($p->catatan_siswa)
                            <div class="text-sm text-gray-600 bg-gray-100 p-2 rounded border border-gray-200">
                                <strong>Catatan:</strong> {{ $p->catatan_siswa }}
                            </div>
                        @endif
                    </td>

                    <!-- Kolom Form Penilaian -->
                    <td class="px-6 py-4 align-top bg-gray-50/50">
                        <form action="/guru/tugas/nilai/{{ $p->id }}" method="POST" class="space-y-3">
                            @csrf
                            <div class="flex items-center space-x-2">
                                <label class="text-sm font-bold text-gray-700 w-16">Nilai:</label>
                                <input type="number" name="nilai" min="0" max="100" value="{{ $p->nilai }}" required class="w-24 border border-gray-300 rounded p-1.5 text-sm focus:ring-blue-500 focus:border-blue-500 font-bold text-center" placeholder="0-100">
                            </div>
                            <div>
                                <textarea name="catatan_guru" rows="2" class="w-full border border-gray-300 rounded p-2 text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Feedback untuk siswa (opsional)...">{{ $p->catatan_guru }}</textarea>
                            </div>
                            <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2 rounded text-sm transition">
                                <i class="fas fa-save mr-1"></i> Simpan Nilai
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-10 text-center text-gray-500 font-medium">
                        <i class="fas fa-inbox text-3xl mb-2 text-gray-300 block"></i>
                        Belum ada siswa yang mengumpulkan tugas ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection