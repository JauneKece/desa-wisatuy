@extends('layouts.app')

@section('title', 'Edit Profil - Desmok')

@section('content')
<div class="container-responsive py-8 md:py-12">
    <!-- Header -->
    <div class="mb-12 animate-slide-in">
        <h1 class="text-5xl md:text-6xl font-outfit font-black mb-2" style="color: #957C62;">👤 Profil {{ auth()->user()->name }}</h1>
        <p class="text-xl" style="color: #B77466;">Kelola informasi akun, password, dan data pribadi Anda</p>
    </div>

    <div class="w-20 h-1 mb-12" style="background-color: #E2B59A;"></div>

    <!-- Profile Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
        <!-- Info Card -->
        <div class="lg:col-span-2 space-y-6">
            <div class="p-6 md:p-8 rounded-3xl border-3" style="background-color: white; border-color: #E2B59A;">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="p-6 md:p-8 rounded-3xl border-3" style="background-color: white; border-color: #E2B59A;">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- User Info Card -->
            <div class="p-6 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #E2B59A;">
                <h3 class="text-xl font-outfit font-bold mb-4" style="color: #957C62;">📋 Informasi Akun</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-semibold" style="color: #B77466;">Nama</p>
                        <p class="text-lg" style="color: #957C62;">{{ auth()->user()->name }}</p>
                    </div>
                    <div class="border-t" style="border-color: #E2B59A;"></div>
                    <div>
                        <p class="text-sm font-semibold" style="color: #B77466;">Email</p>
                        <p class="text-lg" style="color: #957C62;">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="border-t" style="border-color: #E2B59A;"></div>
                    <div>
                        <p class="text-sm font-semibold" style="color: #B77466;">Role</p>
                        <span class="inline-block mt-1 px-3 py-1 rounded-lg text-white font-bold text-sm" style="background-color: #B77466;">
                            @switch(auth()->user()->role)
                                @case('admin')
                                    👨‍💼 Admin
                                @break
                                @case('manager')
                                    📊 Manager
                                @break
                                @case('staff')
                                    👨‍💻 Staff
                                @break
                                @case('customer')
                                    👤 Customer
                                @break
                                @default
                                    {{ ucfirst(auth()->user()->role) }}
                            @endswitch
                        </span>
                    </div>
                    <div class="border-t" style="border-color: #E2B59A;"></div>
                    <div>
                        <p class="text-sm font-semibold" style="color: #B77466;">Terdaftar Sejak</p>
                        <p class="text-lg" style="color: #957C62;">{{ auth()->user()->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="p-6 rounded-2xl border-3" style="background-color: #FFE1AF; border-color: #DC3545;">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

<style>
    .animate-slide-in {
        animation: slideIn 0.6s ease-out forwards;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .text-6xl {
            font-size: 2.5rem;
        }
        
        .text-5xl {
            font-size: 2rem;
        }
    }
</style>
@endsection
