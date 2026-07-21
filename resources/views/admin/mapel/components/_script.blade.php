<script>
    // --- LOGIKA LIVE SEARCH MAPEL ---
    function applyMapelFilter() {
        const searchQuery = document.getElementById('searchMapel').value.toLowerCase();
        let visibleCount = 0;
        
        document.querySelectorAll('.mapel-card').forEach(card => {
            // Ambil teks dari class .mapel-name
            const namaMapel = card.querySelector('.mapel-name').innerText.toLowerCase();
            
            if (namaMapel.includes(searchQuery)) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Tampilkan State Kosong jika tidak ada yang cocok
        const emptyState = document.getElementById('emptySearchMapel');
        const gridContainer = document.getElementById('mapelGrid');
        
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
            gridContainer.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            gridContainer.classList.remove('hidden');
        }
    }

    // --- LOGIKA MODAL HAPUS MAPEL ---
    let currentDeleteId = null;
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const modalMapelName = document.getElementById('modalMapelName');

    function openDeleteModal(id, namaMapel) {
        currentDeleteId = id;
        modalMapelName.innerText = namaMapel;
        
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
        if (currentDeleteId) { 
            document.getElementById('delete-form-' + currentDeleteId).submit(); 
        }
    }
</script>