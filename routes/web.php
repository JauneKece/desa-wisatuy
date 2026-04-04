<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ObjekWisataController;
use App\Http\Controllers\PaketWisataController;
use App\Http\Controllers\PenginapanController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/objek-wisata', [ObjekWisataController::class, 'index'])->name('objek-wisata.index');
Route::get('/objek-wisata/{objekWisata}', [ObjekWisataController::class, 'show'])
    ->whereNumber('objekWisata')
    ->name('objek-wisata.show');

Route::get('/paket-wisata', [PaketWisataController::class, 'index'])->name('paket-wisata.index');
Route::get('/paket-wisata/{paketWisata}', [PaketWisataController::class, 'show'])
    ->whereNumber('paketWisata')
    ->name('paket-wisata.show');

Route::get('/penginapan', [PenginapanController::class, 'index'])->name('penginapan.index');
Route::get('/penginapan/{penginapan}', [PenginapanController::class, 'show'])
    ->whereNumber('penginapan')
    ->name('penginapan.show');

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita}', [BeritaController::class, 'show'])
    ->whereNumber('berita')
    ->name('berita.show');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Reservasi routes - all users can view their own
    Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
    Route::get('/reservasi/create', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/{reservasi}', [ReservasiController::class, 'show'])->name('reservasi.show');
    
    // Customer, admin, and manager can edit/update reservasi (rule details handled in controller)
    Route::middleware('check.role:customer,admin,manager')->group(function () {
        Route::get('/reservasi/{reservasi}/edit', [ReservasiController::class, 'edit'])->name('reservasi.edit');
        Route::patch('/reservasi/{reservasi}', [ReservasiController::class, 'update'])->name('reservasi.update');
    });

    // Customer, Admin & Manager can delete reservasi
    Route::middleware('check.role:customer,admin,manager')->group(function () {
        Route::delete('/reservasi/{reservasi}', [ReservasiController::class, 'destroy'])->name('reservasi.destroy');
    });
    
    // Admin & Manager routes
    Route::middleware('check.role:admin,manager')->group(function () {
        Route::resource('objek-wisata', ObjekWisataController::class)->except(['index', 'show'])->parameters(['objek-wisata' => 'objekWisata']);
        Route::resource('paket-wisata', PaketWisataController::class)->except(['index', 'show'])->parameters(['paket-wisata' => 'paketWisata']);
        Route::resource('penginapan', PenginapanController::class)->except(['index', 'show'])->parameters(['penginapan' => 'penginapan']);
    });
    
    // Staff & Admin can create berita
    Route::middleware('check.role:admin,manager,staff')->group(function () {
        Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
        Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
        Route::get('/berita/{berita}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
        Route::patch('/berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
        Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');
    });

    // Payments (authenticated)
    Route::post('/payments/initiate', [\App\Http\Controllers\PaymentController::class, 'initiate'])->name('payments.initiate');
    Route::get('/reservasi/{reservasi}/payment/manual', [\App\Http\Controllers\PaymentController::class, 'showManual'])->name('payments.manual.form');
    Route::post('/payments/manual', [\App\Http\Controllers\PaymentController::class, 'manualUpload'])->name('payments.manual');
    Route::get('/payments/{payment}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');
    Route::put('/payments/{payment}/reupload', [\App\Http\Controllers\PaymentController::class, 'reupload'])->name('payments.reupload');

    // Admin views for payments
    Route::middleware('check.role:admin,manager')->group(function () {
        Route::get('/admin/payments', [\App\Http\Controllers\PaymentController::class, 'adminIndex'])->name('admin.payments.index');
        Route::get('/admin/payments/{payment}', [\App\Http\Controllers\PaymentController::class, 'adminShow'])->name('admin.payments.show');
        Route::post('/admin/payments/{payment}/verify', [\App\Http\Controllers\PaymentController::class, 'verify'])->name('admin.payments.verify');
    });
});

require __DIR__.'/auth.php';

// Payment gateway webhook (public)
Route::post('/payments/webhook', [\App\Http\Controllers\WebhookController::class, 'handle'])->name('payments.webhook');

