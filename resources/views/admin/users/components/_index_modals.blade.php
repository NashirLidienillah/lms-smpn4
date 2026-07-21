{{-- MODAL DETAIL PROFIL (KTP VIRTUAL) --}}
<div id="detailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 px-4">
    <div id="detailModalContent" class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform scale-95 transition-all duration-300 overflow-hidden">
        
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-6 text-center relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <button onclick="closeDetailModal()" class="absolute top-4 right-4 text-white/70 hover:text-white transition focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div id="modalAvatar" class="w-20 h-20 bg-white text-blue-600 rounded-2xl flex items-center justify-center text-3xl font-bold mx-auto mb-4 shadow-lg uppercase transform rotate-3 hover:rotate-0 transition">
                A
            </div>
            <h3 id="modalName" class="text-xl font-bold text-white mb-1 tracking-tight">Nama Pengguna</h3>
            <span id="modalRoleBadge" class="inline-block bg-white/20 text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest backdrop-blur-md">ROLE</span>
        </div>

        <div class="p-6 space-y-5">
            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Username / ID Akses</label>
                <div class="text-gray-800 font-mono font-medium flex items-center gap-2">
                    <i class="fas fa-fingerprint text-blue-400"></i> <span id="modalUsername">12345678</span>
                </div>
            </div>

            <div id="kelasSection" style="display: none;">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status Rombongan Belajar</label>
                <div id="modalKelasContainer" class="p-4 rounded-xl flex items-center shadow-sm">
                    <i id="modalKelasIcon" class="fas mr-3 text-xl"></i>
                    <span id="modalKelasText" class="font-medium text-sm"></span>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end">
            <button onclick="closeDetailModal()" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-6 py-2.5 rounded-xl text-sm font-bold transition shadow-sm w-full md:w-auto">
                Tutup Profil
            </button>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div id="deleteUserModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300 opacity-0 px-4">
    <div id="deleteUserModalContent" class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm transform scale-95 transition-transform duration-300 relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-32 h-32 bg-red-50 rounded-full blur-2xl"></div>
        <div class="flex items-center justify-center w-16 h-16 mx-auto bg-red-100 text-red-600 rounded-full mb-4 border-4 border-white shadow-sm relative z-10">
            <i class="fas fa-user-times text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-center text-gray-800 mb-2 relative z-10">Hapus Pengguna?</h3>
        <p class="text-center text-gray-500 text-sm mb-6 relative z-10 leading-relaxed">
            Yakin ingin menghapus <span id="deleteRoleBadge" class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider mx-1"></span> <br> 
            <span id="deleteUserName" class="font-bold text-gray-800 text-base"></span>?
        </p>
        <div class="flex space-x-3 relative z-10">
            <button onclick="closeDeleteModal()" class="flex-1 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded-xl transition shadow-sm">Batal</button>
            <button onclick="submitDeleteForm()" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl shadow-sm transition">Ya, Hapus</button>
        </div>
    </div>
</div>