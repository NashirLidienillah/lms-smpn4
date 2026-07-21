{{-- ================= NOTIFIKASI TOAST MELAYANG ================= --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-xl shadow-xl border-l-4 border-emerald-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-emerald-500 bg-emerald-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
@endif

@if(session('error'))
    <div id="toast-error" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-xl shadow-xl border-l-4 border-red-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="ml-3 text-sm font-medium leading-tight">{{ session('error') }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-error').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-error')?.remove(); }, 4500);</script>
@endif

@if($errors->any())
    <div id="toast-validation" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-xl shadow-xl border-l-4 border-amber-500 z-50 transition-all duration-500">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-amber-500 bg-amber-100 rounded-lg"><i class="fas fa-exclamation-circle"></i></div>
        <div class="ml-3 text-sm font-medium leading-tight">{{ $errors->first() }}</div>
        <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-validation').remove()"><i class="fas fa-times"></i></button>
    </div>
    <script>setTimeout(() => { document.getElementById('toast-validation')?.remove(); }, 4500);</script>
@endif
{{-- ========================================================= --}}

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col md:flex-row items-start md:items-center justify-between relative overflow-hidden mb-6">
    <div class="absolute left-0 top-0 w-1.5 h-full bg-blue-600"></div>
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Jadwal Pelajaran</h2>
        <p class="text-sm text-gray-500 mt-1">Mengatur jadwal mengajar guru pada tahun ajaran aktif.</p>
    </div>
    <div class="mt-4 md:mt-0 text-left md:text-right w-full md:w-auto">
        <span class="block text-[10px] text-gray-400 mb-1.5 uppercase tracking-widest font-black">Tahun Ajaran Aktif</span>
        <span class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-2.5 rounded-xl text-sm font-bold inline-flex items-center w-full md:w-auto justify-center shadow-sm">
            <i class="fas fa-calendar-check mr-2"></i> {{ $tahunAktif->nama_tahun }} ({{ $tahunAktif->semester }})
        </span>
    </div>
</div>