<script>
    let currentRoleFilter = 'semua';

    function changeTab(role) {
        currentRoleFilter = role;
        document.querySelectorAll('.tab-btn').forEach(btn => {
            if(btn.dataset.target === role) {
                btn.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.remove('bg-white', 'text-gray-600', 'hover:bg-gray-100');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                btn.classList.add('bg-white', 'text-gray-600', 'hover:bg-gray-100');
            }
        });
        applyFilters();
    }

    function applyFilters() {
        const searchQuery = document.getElementById('searchInput').value.toLowerCase();
        let visibleCount = 0;
        let serialCounter = 1; 
        
        document.querySelectorAll('.user-row').forEach(row => {
            const rowText = row.innerText.toLowerCase();
            const matchesRole = (currentRoleFilter === 'semua' || row.dataset.role === currentRoleFilter);
            const matchesSearch = rowText.includes(searchQuery);

            if (matchesRole && matchesSearch) {
                row.style.display = '';
                row.querySelector('.serial-number').innerText = serialCounter++;
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const emptyState = document.getElementById('empty-state');
        if (visibleCount === 0) {
            emptyState.style.display = '';
        } else {
            emptyState.style.display = 'none';
        }
    }

    const detailModal = document.getElementById('detailModal');
    const detailModalContent = document.getElementById('detailModalContent');

    function openDetailModal(name, username, role, infoKelas, isBelumMasukKelas) {
        document.getElementById('modalAvatar').innerText = name.substring(0, 1);
        document.getElementById('modalName').innerText = name;
        document.getElementById('modalUsername').innerText = username;
        document.getElementById('modalRoleBadge').innerText = role;

        const kelasSection = document.getElementById('kelasSection');
        const kelasContainer = document.getElementById('modalKelasContainer');
        const kelasIcon = document.getElementById('modalKelasIcon');
        const kelasText = document.getElementById('modalKelasText');

        if (role === 'siswa') {
            kelasSection.style.display = 'block';
            kelasText.innerText = infoKelas;

            if (isBelumMasukKelas) {
                kelasContainer.className = "p-4 rounded-xl border border-red-100 bg-red-50 flex items-center text-red-700";
                kelasIcon.className = "fas fa-exclamation-circle mr-3 text-xl";
            } else {
                kelasContainer.className = "p-4 rounded-xl border border-green-100 bg-green-50 flex items-center text-green-700";
                kelasIcon.className = "fas fa-check-circle mr-3 text-xl";
            }
        } else {
            kelasSection.style.display = 'none';
        }

        detailModal.classList.remove('hidden');
        setTimeout(() => {
            detailModal.classList.remove('opacity-0');
            detailModalContent.classList.remove('scale-95');
            detailModalContent.classList.add('scale-100');
        }, 10);
    }

    function closeDetailModal() {
        detailModal.classList.add('opacity-0');
        detailModalContent.classList.remove('scale-100');
        detailModalContent.classList.add('scale-95');
        setTimeout(() => { detailModal.classList.add('hidden'); }, 300);
    }

    let currentDeleteId = null;
    const deleteUserModal = document.getElementById('deleteUserModal');
    const deleteUserModalContent = document.getElementById('deleteUserModalContent');
    const deleteUserName = document.getElementById('deleteUserName');
    const deleteRoleBadge = document.getElementById('deleteRoleBadge');

    function openDeleteModal(id, name, role) {
        currentDeleteId = id;
        deleteUserName.innerText = name;
        
        deleteRoleBadge.innerText = role;
        if(role === 'admin') {
            deleteRoleBadge.className = 'inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider mx-1 bg-red-100 text-red-600';
        } else if(role === 'guru') {
            deleteRoleBadge.className = 'inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider mx-1 bg-emerald-100 text-emerald-600';
        } else {
            deleteRoleBadge.className = 'inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider mx-1 bg-blue-100 text-blue-600';
        }

        deleteUserModal.classList.remove('hidden');
        setTimeout(() => {
            deleteUserModal.classList.remove('opacity-0');
            deleteUserModalContent.classList.remove('scale-95');
            deleteUserModalContent.classList.add('scale-100');
        }, 10);
    }

    function closeDeleteModal() {
        deleteUserModal.classList.add('opacity-0');
        deleteUserModalContent.classList.remove('scale-100');
        deleteUserModalContent.classList.add('scale-95');
        setTimeout(() => { deleteUserModal.classList.add('hidden'); currentDeleteId = null; }, 300);
    }

    function submitDeleteForm() {
        if (currentDeleteId) { document.getElementById('delete-user-form-' + currentDeleteId).submit(); }
    }
</script>