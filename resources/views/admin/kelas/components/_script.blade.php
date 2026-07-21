<script>
    // --- LOGIKA FILTER & SEARCH KELAS ---
    let currentTingkatFilter = 'semua';

    function filterKelas(tingkat) {
        currentTingkatFilter = tingkat;
        
        // Ubah warna tombol Tab yang aktif
        document.querySelectorAll('.tab-kelas-btn').forEach(btn => {
            if(btn.dataset.target === tingkat) {
                btn.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.remove('bg-gray-50', 'text-gray-500', 'hover:bg-gray-100', 'border', 'border-gray-200');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.add('bg-gray-50', 'text-gray-500', 'hover:bg-gray-100', 'border', 'border-gray-200');
            }
        });
        
        applyKelasFilter();
    }

    function applyKelasFilter() {
        const searchQuery = document.getElementById('searchKelas').value.toLowerCase().replace(/\s+/g, ''); 
        let visibleCount = 0;
        
        document.querySelectorAll('.kelas-card').forEach(card => {
            const namaKelas = card.querySelector('.text-lg').innerText.toLowerCase().replace(/\s+/g, '');
            const cardTingkat = card.dataset.tingkat;
            
            const matchesTingkat = (currentTingkatFilter === 'semua' || cardTingkat === currentTingkatFilter);
            const matchesSearch = namaKelas.includes(searchQuery);

            if (matchesTingkat && matchesSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Tampilkan State Kosong jika tidak ada yang cocok
        const emptyState = document.getElementById('emptySearchKelas');
        const gridContainer = document.getElementById('kelasGrid');
        
        if (visibleCount === 0) {
            emptyState.classList.remove('hidden');
            gridContainer.classList.add('hidden');
        } else {
            emptyState.classList.add('hidden');
            gridContainer.classList.remove('hidden');
        }
    }

    // --- LOGIKA MODAL HAPUS KELAS ---
    let currentDeleteId = null;
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const modalClassName = document.getElementById('modalClassName');

    function openDeleteModal(id, namaKelas) {
        currentDeleteId = id;
        modalClassName.innerText = namaKelas; 
        
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