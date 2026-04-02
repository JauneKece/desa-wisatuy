<h3 class="text-2xl font-outfit font-bold mb-4" style="color: #DC3545;">🗑️ Hapus Akun</h3>
<p class="mb-6 text-sm" style="color: #666;">⚠️ Setelah akun dihapus, semua data dan resource Anda akan dihapus secara permanen. Pastikan Anda telah mengunduh data penting sebelumnya.</p>

<button type="button" 
        class="px-6 py-3 text-white font-bold rounded-lg transition duration-150" 
        style="background-color: #DC3545;"
        onmouseover="this.style.backgroundColor='#C82333'"
        onmouseout="this.style.backgroundColor='#DC3545'"
        onclick="document.getElementById('delete-modal').style.display='flex'">
    🗑️ Hapus Akun Saya
</button>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl shadow-lg max-w-md w-full p-6 md:p-8" style="border-color: #DC3545; border: 3px solid #DC3545;">
        <h2 class="text-2xl font-outfit font-bold mb-4" style="color: #DC3545;">
            ⚠️ Konfirmasi Penghapusan Akun
        </h2>
        
        <p class="mb-6" style="color: #666;">
            Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.
        </p>

        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-5">
            @csrf
            @method('delete')

            <!-- Password Confirmation -->
            <div>
                <label for="delete-password" class="block text-sm font-bold mb-2" style="color: #957C62;">Masukkan Password Anda untuk Konfirmasi</label>
                <input type="password" 
                       id="delete-password" 
                       name="password" 
                       class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" 
                       style="border-color: #DC3545; background-color: #FFE1AF; color: #957C62;" 
                       placeholder="••••••••"
                       required>
                @error('password', 'userDeletion')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button type="button" 
                        class="flex-1 px-4 py-3 text-white font-bold rounded-lg transition duration-150" 
                        style="background-color: #957C62;"
                        onmouseover="this.style.backgroundColor='#7A5F4A'"
                        onmouseout="this.style.backgroundColor='#957C62'"
                        onclick="document.getElementById('delete-modal').style.display='none'">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-3 text-white font-bold rounded-lg transition duration-150" 
                        style="background-color: #DC3545;"
                        onmouseover="this.style.backgroundColor='#C82333'"
                        onmouseout="this.style.backgroundColor='#DC3545'">
                    Hapus Selamanya
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Close modal when clicking outside
    document.getElementById('delete-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
        }
    });
</script>
