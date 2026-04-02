<h3 class="text-2xl font-outfit font-bold mb-6" style="color: #957C62;">🔐 Ubah Password</h3>
<p class="mb-6" style="color: #B77466;">Pastikan akun Anda menggunakan password yang kuat dan acak untuk keamanan maksimal.</p>

<form method="post" action="{{ route('password.update') }}" class="space-y-5">
    @csrf
    @method('put')

    <!-- Current Password -->
    <div>
        <label for="current_password" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Password Saat Ini</label>
        <input type="password" id="current_password" name="current_password" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" autocomplete="current-password" required>
        @error('current_password', 'updatePassword')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- New Password -->
    <div>
        <label for="password" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Password Baru</label>
        <input type="password" id="password" name="password" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" autocomplete="new-password" required>
        @error('password', 'updatePassword')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div>
        <label for="password_confirmation" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Konfirmasi Password Baru</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" autocomplete="new-password" required>
        @error('password_confirmation', 'updatePassword')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="flex gap-3">
        <button type="submit" class="px-6 py-3 text-white font-bold rounded-lg transition duration-150" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
            ✅ Perbarui Password
        </button>

        @if (session('status') === 'password-updated')
            <p class="flex items-center text-sm font-semibold" style="color: #28A745;">
                ✓ Password berhasil diperbarui!
            </p>
        @endif
    </div>
</form>
