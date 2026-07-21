{{-- ================= MODAL KONFIRMASI KELUARKAN ================= --}}
<div id="removeModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 px-4">
    <div id="removeModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300 relative overflow-hidden">
        
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-orange-50 rounded-full blur-2xl"></div>

        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-orange-100 text-orange-600 rounded-full mb-4 border-4 border-white shadow-sm relative z-10">
            <i class="fas fa-user-minus text-2xl"></i>
        </div>
        
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2 relative z-10">Keluarkan Siswa?</h3>
        <p class="text-center text-gray-500 text-sm mb-6 relative z-10">
            Yakin ingin mengeluarkan <span id="namaSiswaLabel" class="font-bold text-gray-800 bg-gray-100 px-1 py-0.5 rounded"></span> dari kelas ini?
        </p>
        
        <div class="flex space-x-3 relative z-10">
            <button onclick="closeRemoveModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded-xl transition shadow-sm">
                Batal
            </button>
            <button onclick="submitRemoveForm()" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2.5 rounded-xl shadow-sm transition">
                Ya, Keluarkan
            </button>
        </div>
    </div>
</div>