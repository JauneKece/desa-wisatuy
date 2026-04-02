<x-guest-layout>
    <div class="mb-4 text-sm" style="color: #957C62;">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm px-4 py-3 rounded-lg" style="background-color: #FFE1AF; color: #957C62; border-left: 4px solid #B77466;">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="no-underline text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all" style="color: #957C62; focus-ring-color: #B77466; focus-ring-offset-color: #FFE1AF;">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
