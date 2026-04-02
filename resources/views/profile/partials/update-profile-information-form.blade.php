<h3 class="text-2xl font-outfit font-bold mb-6" style="color: #957C62;">👤 Informasi Profil</h3>
<p class="mb-6" style="color: #B77466;">Perbarui nama dan email akun Anda di bawah ini.</p>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-5">
    @csrf
    @method('patch')

    <!-- Name Field -->
    <div>
        <label for="name" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Nama Lengkap</label>
        <input type="text" id="name" name="name" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Field -->
    <div>
        <label for="email" class="block text-sm md:text-base font-bold mb-2" style="color: #957C62;">Email</label>
        <input type="email" id="email" name="email" class="w-full px-4 py-2 rounded-lg border-2 focus:outline-none focus:ring-2" style="border-color: #E2B59A; background-color: #FFE1AF; color: #957C62;" value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Verification Status -->
    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="p-4 rounded-lg" style="background-color: #FFF3CD; border-left: 4px solid #FFC107;">
            <p class="text-sm" style="color: #857704;">
                📧 Email Anda belum diverifikasi.
                <button form="send-verification" class="font-semibold no-underline" style="color: #857704;">
                    Klik di sini untuk mengirim ulang email verifikasi.
                </button>
            </p>

            @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-semibold text-sm" style="color: #155724;">
                    ✅ Email verifikasi telah dikirim ke alamat email Anda.
                </p>
            @endif
        </div>
    @endif

    <!-- Submit Button -->
    <div class="flex gap-3">
        <button type="submit" class="px-6 py-3 text-white font-bold rounded-lg transition duration-150" style="background-color: #B77466;" onmouseover="this.style.backgroundColor='#957C62'" onmouseout="this.style.backgroundColor='#B77466'">
            ✅ Simpan Perubahan
        </button>

        @if (session('status') === 'profile-updated')
            <p class="flex items-center text-sm font-semibold" style="color: #28A745;">
                ✓ Profil berhasil diperbarui!
            </p>
        @endif
    </div>
</form>
