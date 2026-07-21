{{-- ================= NOTIFIKASI TOAST MELAYANG ================= --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-xl shadow-xl border-l-4 border-green-500 z-50 transition-all duration-500" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg"><i class="fas fa-check"></i></div>
        <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 transition" onclick="closeToast()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <script>
        function closeToast() {
            const toast = document.getElementById('toast-success');
            if (toast) { toast.classList.add('opacity-0', 'translate-x-full'); setTimeout(() => toast.remove(), 500); }
        }
        setTimeout(() => { closeToast(); }, 3500);
    </script>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Master Data Mata Pelajaran</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola daftar mata pelajaran yang diajarkan di SMPN 4 Kota Serang.</p>
    </div>
</div>