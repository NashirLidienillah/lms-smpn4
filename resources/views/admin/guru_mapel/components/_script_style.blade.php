<style>
    /* Styling scrollbar custom untuk dropdown alpine */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; border-radius: 8px;}
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

<script>
    // --- LOGIKA FILTER TAB HARI, DROPDOWN KELAS & LIVE SEARCH ---
    let currentHariFilter = 'semua';
    let currentKelasFilter = 'semua';

    function filterHari(hari) {
        currentHariFilter = hari;
        
        // Ubah styling tombol tab
        document.querySelectorAll('.tab-hari-btn').forEach(btn => {
            if(btn.dataset.target === hari) {
                btn.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.remove('bg-gray-50', 'text-gray-500', 'hover:bg-gray-100', 'border', 'border-gray-200');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.add('bg-gray-50', 'text-gray-500', 'hover:bg-gray-100', 'border', 'border-gray-200');
            }
        });
        
        applyJadwalFilter();
    }

    function filterKelas(kelas) {
        currentKelasFilter = kelas;
        applyJadwalFilter();
    }

    function applyJadwalFilter() {
        const searchQuery = document.getElementById('searchJadwal').value.toLowerCase();
        let visibleCount = 0;
        
        document.querySelectorAll('.jadwal-card').forEach(card => {
            const cardHari = card.dataset.hari;
            const cardKelas = card.dataset.kelas; 
            
            const namaMapel = card.querySelector('.jadwal-mapel').innerText.toLowerCase();
            const namaGuru = card.querySelector('.jadwal-guru').innerText.toLowerCase();
            const namaKelasText = card.querySelector('.jadwal-kelas').innerText.toLowerCase(); 
            
            const matchesHari = (currentHariFilter === 'semua' || cardHari === currentHariFilter);
            const matchesKelas = (currentKelasFilter === 'semua' || cardKelas === currentKelasFilter);
            const matchesSearch = namaMapel.includes(searchQuery) || namaGuru.includes(searchQuery) || namaKelasText.includes(searchQuery);

            if (matchesHari && matchesKelas && matchesSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const emptyState = document.getElementById('emptySearchJadwal');
        const gridContainer = document.getElementById('jadwalGrid');
        
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
            gridContainer.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            gridContainer.classList.remove('hidden');
        }
    }

    // --- LOGIKA MODAL HAPUS ---
    let currentDeleteId = null;
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const detailGuruLabel = document.getElementById('detailGuruLabel');
    const detailMapelLabel = document.getElementById('detailMapelLabel');
    const detailKelasLabel = document.getElementById('detailKelasLabel');

    function openDeleteModal(id, namaGuru, namaMapel, namaKelas) {
        currentDeleteId = id;
        detailGuruLabel.innerText = namaGuru; 
        detailMapelLabel.innerText = namaMapel; 
        detailKelasLabel.innerText = 'Kelas ' + namaKelas; 
        
        deleteModal.classList.remove('hidden');
        setTimeout(() => {
            deleteModal.classList.remove('opacity-0');
            deleteModalContent.classList.remove('scale-95');
            deleteModalContent.classList.add('scale-100');
        }, 10);
    }

    function closeDeleteModal() {
        deleteModal.classList.add('opacity-0');
        deleteModalContent.classList.remove('scale-100');
        deleteModalContent.classList.add('scale-95');
        setTimeout(() => { 
            deleteModal.classList.add('hidden'); 
            currentDeleteId = null; 
        }, 300);
    }

    function submitDeleteForm() {
        if (currentDeleteId) { document.getElementById('delete-form-' + currentDeleteId).submit(); }
    }
</script>