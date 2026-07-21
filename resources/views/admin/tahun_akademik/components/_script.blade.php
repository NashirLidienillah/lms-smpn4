<script>
    // JS MODAL HAPUS
    let currentDeleteId = null;
    const deleteModal = document.getElementById('deleteModal');
    const deleteModalContent = document.getElementById('deleteModalContent');
    const detailDataLabel = document.getElementById('detailDataLabel');

    function openDeleteModal(id, namaData) {
        currentDeleteId = id; detailDataLabel.innerText = namaData; 
        deleteModal.classList.remove('hidden');
        setTimeout(() => { deleteModal.classList.remove('opacity-0'); deleteModalContent.classList.remove('scale-95'); deleteModalContent.classList.add('scale-100'); }, 10);
    }
    function closeDeleteModal() {
        deleteModal.classList.add('opacity-0'); deleteModalContent.classList.remove('scale-100'); deleteModalContent.classList.add('scale-95');
        setTimeout(() => { deleteModal.classList.add('hidden'); currentDeleteId = null; }, 300);
    }
    function submitDeleteForm() { if (currentDeleteId) document.getElementById('delete-form-' + currentDeleteId).submit(); }

    // JS MODAL AKTIFKAN
    let currentActivateId = null;
    const activateModal = document.getElementById('activateModal');
    const activateModalContent = document.getElementById('activateModalContent');
    const detailActivateLabel = document.getElementById('detailActivateLabel');

    function openActivateModal(id, namaData) {
        currentActivateId = id; detailActivateLabel.innerText = namaData; 
        activateModal.classList.remove('hidden');
        setTimeout(() => { activateModal.classList.remove('opacity-0'); activateModalContent.classList.remove('scale-95'); activateModalContent.classList.add('scale-100'); }, 10);
    }
    function closeActivateModal() {
        activateModal.classList.add('opacity-0'); activateModalContent.classList.remove('scale-100'); activateModalContent.classList.add('scale-95');
        setTimeout(() => { activateModal.classList.add('hidden'); currentActivateId = null; }, 300);
    }
    function submitActivateForm() { if (currentActivateId) document.getElementById('activate-form-' + currentActivateId).submit(); }
</script>