<!-- Modal Konfirmasi Hapus -->
<div id="confirmDeleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/30">
    <div class="bg-white/10 backdrop-blur-lg p-6 rounded-2xl shadow-2xl w-96 border border-white/20 relative">
        <h2 class="text-lg font-semibold text-white mb-4">Yakin ingin menghapus data ini?</h2>
        
        <form id="confirmDeleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-white/20 text-white hover:bg-white/30 rounded-md transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                    Hapus
                </button>
            </div>
        </form>

        <!-- Tombol Close (X) -->
        <button onclick="closeModal()" class="absolute top-3 right-3 text-white hover:text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>

{{-- ✅ SCRIPT --}}
<script>
    function showModal(actionUrl) {
        const modal = document.getElementById('confirmDeleteModal');
        const form = document.getElementById('confirmDeleteForm');
        form.action = actionUrl;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('confirmDeleteModal');
        modal.classList.add('hidden');
    }
</script>
