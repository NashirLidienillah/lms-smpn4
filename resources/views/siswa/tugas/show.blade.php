@extends('layouts.app')

@section('content')
<div class="mb-6">
    <a href="/siswa/kelas/{{ $tugas->guru_mapel_id }}" class="inline-flex items-center text-sm text-gray-500 hover:text-blue-600 transition mb-4 font-medium">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Ruang Kelas
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Kolom Kiri: Detail Tugas -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">
            <div class="flex items-center space-x-2 text-sm text-blue-600 font-bold mb-3">
                <i class="fas fa-book"></i>
                <span>{{ $tugas->guruMapel->mapel->nama_mapel ?? 'Mata Pelajaran' }}</span>
            </div>
            
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">{{ $tugas->judul }}</h1>
            
            <div class="flex items-center text-sm text-gray-500 mb-6 bg-gray-50 p-3 rounded-lg border border-gray-100">
                <i class="fas fa-user-tie mr-2"></i> Oleh: {{ $tugas->guruMapel->user->name ?? 'Guru' }}
                <span class="mx-3 text-gray-300">|</span>
                <i class="far fa-clock mr-2"></i> Deadline: <span class="font-bold text-red-500 ml-1">{{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y - H:i') }}</span>
            </div>

            <div class="prose max-w-none text-gray-600 mb-6 border-b border-gray-100 pb-6">
                {!! nl2br(e($tugas->deskripsi)) !!}
            </div>

            @if($tugas->file_tugas)
            <div>
                <h4 class="text-sm font-bold text-gray-700 mb-2">Lampiran dari Guru:</h4>
                <a href="{{ asset('storage/tugas/' . $tugas->file_tugas) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-semibold hover:bg-blue-600 hover:text-white transition">
                    <i class="fas fa-download mr-2"></i> Download Lampiran Soal
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Kolom Kanan: Status & Form Pengumpulan -->
    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Status Pengumpulan</h3>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm font-bold">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif

            @if($jawaban)
                <!-- Jika Sudah Mengumpulkan -->
                <div class="text-center py-6">
                    <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-3 text-3xl shadow-inner">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4 class="font-bold text-gray-800">Tugas Diserahkan</h4>
                    <p class="text-xs text-gray-500 mt-1">Pada: {{ $jawaban->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                <div class="mt-4 bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <p class="text-xs text-gray-500 font-bold mb-1 uppercase">File Jawaban Anda:</p>
                    <a href="{{ asset('uploads/tugas/' . $jawaban->file_jawaban) }}" target="_blank" class="text-blue-600 hover:underline text-sm break-all font-medium">
                        <i class="fas fa-file-alt mr-1"></i> {{ $jawaban->file_jawaban }}
                    </a>
                </div>

                <!-- Bagian Nilai -->
                <div class="mt-6 border-t pt-4">
                    <h4 class="text-sm font-bold text-gray-700 mb-2">Nilai dari Guru:</h4>
                    @if($jawaban->nilai !== null)
                        <div class="flex items-center justify-between bg-emerald-50 border border-emerald-200 p-3 rounded-lg">
                            <span class="text-emerald-700 font-bold text-2xl">{{ $jawaban->nilai }}</span>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full">Dinilai</span>
                        </div>
                        @if($jawaban->catatan_guru)
                            <div class="mt-2 text-sm text-gray-600 bg-yellow-50 p-3 border-l-4 border-yellow-400 rounded">
                                <strong>Feedback Guru:</strong> <br> {{ $jawaban->catatan_guru }}
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-100 text-gray-500 text-sm p-3 rounded-lg text-center font-medium shadow-inner">
                            <i class="fas fa-hourglass-half mr-1"></i> Belum dinilai
                        </div>
                    @endif
                </div>

            @else
                <!-- Jika Belum Mengumpulkan -->
                <div class="bg-amber-50 border-l-4 border-amber-500 p-3 rounded text-sm mb-5 shadow-sm">
                    <span class="font-bold text-amber-700">Perhatian:</span> Segera kumpulkan tugas sebelum batas waktu berakhir.
                </div>

                <!-- ACTION FORM DIUBAH KE /kumpul SESUAI ROUTE -->
                <form action="/siswa/tugas/{{ $tugas->id }}/kumpul" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload File Jawaban <span class="text-red-500">*</span></label>
                        <input type="file" name="file_jawaban" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:outline-none transition border border-gray-200 rounded-md">
                        <p class="text-xs text-gray-400 mt-1">Format: PDF, DOCX, JPG, PNG, ZIP. Maks 5MB.</p>
                        @error('file_jawaban') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Catatan untuk Guru (Opsional)</label>
                        <textarea name="catatan_siswa" rows="3" class="w-full border border-gray-300 rounded-lg p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm bg-gray-50" placeholder="Tulis pesan jika ada..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition duration-300 shadow-md">
                        <i class="fas fa-paper-plane mr-2"></i> Serahkan Tugas
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection