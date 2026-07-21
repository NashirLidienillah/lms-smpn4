{{-- MODAL AKTIFKAN --}}
<div id="activateModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 px-4">
    <div id="activateModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300 relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-green-50 rounded-full blur-2xl"></div>
        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-green-100 text-green-600 rounded-full mb-4 border-4 border-white shadow-sm relative z-10">
            <i class="fas fa-power-off text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2 relative z-10">Nyalakan Periode Ini?</h3>
        <p class="text-center text-gray-500 text-sm mb-6 relative z-10">
            Sistem akan berpindah ke <span id="detailActivateLabel" class="font-bold text-gray-800"></span>.<br><br>
            <span class="text-amber-600 bg-amber-50 px-2 py-1 rounded border border-amber-100 text-xs mt-2 inline-block"><i class="fas fa-info-circle mr-1"></i>Periode lain akan dinonaktifkan otomatis.</span>
        </p>
        <div class="flex space-x-3 relative z-10">
            <button onclick="closeActivateModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded-xl transition shadow-sm">Batal</button>
            <button onclick="submitActivateForm()" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-xl shadow-sm transition">Mulai Periode</button>
        </div>
    </div>
</div>