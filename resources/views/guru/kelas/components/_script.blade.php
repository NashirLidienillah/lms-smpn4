{{-- Script Eksekusi Bawah --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // FUNGSI MODAL PENGUMUMAN
    function bukaModalPengumuman() {
        document.getElementById('modal-pengumuman').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; 
    }
    
    function tutupModalPengumuman() {
        document.getElementById('modal-pengumuman').classList.add('hidden');
        document.body.style.overflow = 'auto'; 
    }

    // FUNGSI UNIVERSAL DELETE
    function hapusDataAdminStyle(formId, namaItem) {
        Swal.fire({
            title: 'Hapus Data?',
            html: `Apakah Anda yakin ingin menghapus <b>${namaItem}</b>?<br><span class="text-sm text-gray-500">Data yang dihapus tidak dapat dikembalikan.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444', 
            cancelButtonColor: '#f1f5f9', 
            cancelButtonText: '<span style="color: #475569">Batal</span>',
            confirmButtonText: 'Ya, Hapus!',
            reverseButtons: true,
            customClass: { confirmButton: 'shadow-lg shadow-red-200 font-bold', cancelButton: 'font-bold' }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...', text: 'Sedang menghapus data.', allowOutsideClick: false, showConfirmButton: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                document.getElementById(formId).submit();
            }
        });
    }

    // FUNGSI TAB & FORM UI
    function toggleTipeInput() {
        const tipe = document.getElementById('tipe_materi').value;
        if (tipe === 'file') {
            document.getElementById('box_file').classList.remove('hidden');
            document.getElementById('box_youtube').classList.add('hidden');
        } else {
            document.getElementById('box_youtube').classList.remove('hidden');
            document.getElementById('box_file').classList.add('hidden');
        }
    }

    // TEMA WARNA BERSATU (Semua Tab Aktif Pakai Biru)
    function gantiTab(tabAktif) {
        ['materi', 'tugas', 'ujian'].forEach(tab => {
            document.getElementById('konten-' + tab).classList.add('hidden');
            let btn = document.getElementById('btn-tab-' + tab);
            btn.className = "flex-1 min-w-[120px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2 text-gray-400 hover:bg-gray-100";
        });

        document.getElementById('konten-' + tabAktif).classList.remove('hidden');
        let btnAktif = document.getElementById('btn-tab-' + tabAktif);
        
        // Cukup 1 style yang sama untuk semua tab aktif (Corporate Unity)
        btnAktif.className = "flex-1 min-w-[120px] py-3.5 rounded-xl text-sm font-black transition-all duration-300 flex items-center justify-center gap-2 bg-blue-600 text-white shadow-lg shadow-blue-100";

        sessionStorage.setItem('tabKelasAktif', tabAktif);
    }

    document.addEventListener('DOMContentLoaded', function() {
        let tabTerakhir = sessionStorage.getItem('tabKelasAktif');
        if(!['materi', 'tugas', 'ujian'].includes(tabTerakhir)) tabTerakhir = 'materi';
        gantiTab(tabTerakhir);
    });
</script>