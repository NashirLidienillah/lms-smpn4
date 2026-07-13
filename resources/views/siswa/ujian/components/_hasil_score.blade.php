{{-- Rincian Score Box --}}
<div class="grid grid-cols-3 gap-4 mb-10">
    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Benar</p>
        <p class="text-2xl font-black text-emerald-600">{{ $jawabanBenar }}</p>
    </div>
    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Salah</p>
        <p class="text-2xl font-black text-red-500">{{ $totalSoal - $jawabanBenar }}</p>
    </div>
    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Total Soal</p>
        <p class="text-2xl font-black text-blue-600">{{ $totalSoal }}</p>
    </div>
</div>

<div class="mb-10">
    <p class="text-sm text-gray-400 mb-1 font-bold uppercase tracking-widest">Skor Akhir</p>
    <div class="text-7xl font-black text-blue-800">{{ $nilai }}</div>
</div>