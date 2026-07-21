<style>
    /* Styling scrollbar custom untuk dropdown agar lebih elegan */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; border-radius: 8px;}
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

<script>
    // --- LOGIKA LIVE SEARCH SISWA ---
    function applySiswaFilter() {
        const searchQuery = document.getElementById('searchSiswa').value.toLowerCase();
        let visibleCount = 0;
        
        document.querySelectorAll('.siswa-card').forEach(card => {
            const nama = card.querySelector('.siswa-name').innerText.toLowerCase();
            const nis = card.querySelector('.siswa-nis').innerText.toLowerCase();
            
            // Cek apakah input cocok dengan Nama atau NIS
            if (nama.includes(searchQuery) || nis.includes(searchQuery)) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const emptyState = document.getElementById('emptySearchSiswa');
        const gridContainer = document.getElementById('siswaGrid');
        
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
            gridContainer.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            gridContainer.classList.remove('hidden');
        }
    }

    // --- LOGIKA MODAL KELUARKAN SISWA ---
    let currentRemoveId = null;
    const removeModal = document.getElementById('removeModal');
    const removeModalContent = document.getElementById('removeModalContent');
    const namaSiswaLabel = document.getElementById('namaSiswaLabel');

    function openRemoveModal(id, nama) {
        currentRemoveId = id;
        namaSiswaLabel.innerText = nama; 
        
        removeModal.classList.remove('hidden');
        setTimeout(() => {
            removeModal.classList.remove('opacity-0');
            removeModalContent.classList.remove('scale-95');
            removeModalContent.classList.add('scale-100');
        }, 10);
    }

    function closeRemoveModal() {
        removeModal.classList.add('opacity-0');
        removeModalContent.classList.remove('scale-100');
        removeModalContent.classList.add('scale-95');
        setTimeout(() => { removeModal.classList.add('hidden'); currentRemoveId = null; }, 300);
    }

    function submitRemoveForm() {
        if (currentRemoveId) { document.getElementById('remove-form-' + currentRemoveId).submit(); }
    }
</script>