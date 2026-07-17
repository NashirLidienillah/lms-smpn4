{{-- Notifikasi Toast --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-2xl shadow-xl border-l-4 border-green-500 z-[9999] transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

@if($errors->any())
    <div id="toast-error" class="fixed top-5 right-5 flex items-start w-full max-w-md p-5 mb-4 text-gray-700 bg-white rounded-2xl shadow-2xl border-l-4 border-red-500 z-[9999] transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-red-500 bg-red-50 rounded-xl mt-0.5"><i class="fas fa-exclamation-circle text-xl"></i></div>
        <div class="ml-4 text-sm">
            <span class="font-bold text-red-600 block mb-1 text-base">Kesalahan Validasi Data</span>
            <ul class="list-disc pl-4 text-gray-500 space-y-1 text-xs font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button type="button" class="ml-auto text-gray-300 hover:text-gray-900 transition" onclick="document.getElementById('toast-error').remove()"><i class="fas fa-times"></i></button>
    </div>
@endif

{{-- Header Action Bar --}}
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <a href="/guru/dashboard" class="group inline-flex items-center text-sm font-bold text-gray-400 hover:text-blue-600 transition">
        <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-blue-50 flex items-center justify-center mr-3 transition">
            <i class="fas fa-arrow-left text-xs"></i>
        </div>
        Kembali ke Beranda Guru
    </a>

    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
        <button onclick="bukaModalPengumuman()" class="w-full sm:w-auto bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-sm shadow-amber-200 transition flex items-center justify-center gap-2">
            <i class="fas fa-bullhorn"></i> Info & Pengumuman
        </button>

        <a href="/guru/kelas/{{ $jadwal->id }}/rekap-nilai" class="w-full sm:w-auto bg-white border border-blue-200 text-blue-600 hover:bg-blue-600 hover:text-white text-sm font-bold px-5 py-2.5 rounded-xl shadow-sm transition flex items-center justify-center gap-2">
            <i class="fas fa-chart-bar"></i> Rekap Nilai Siswa
        </a>
    </div>
</div>