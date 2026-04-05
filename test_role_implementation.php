<?php

// Quick test script to verify role implementation
require_once 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Enums\UserRole;

echo "\n=== ROLE IMPLEMENTATION TEST ===\n\n";

echo "1. Testing UserRole Enum:\n";
echo "   - ADMIN: " . UserRole::ADMIN . "\n";
echo "   - OWNER: " . UserRole::OWNER . "\n";
echo "   - BENDAHARA: " . UserRole::BENDAHARA . "\n";
echo "   - PELANGGAN: " . UserRole::PELANGGAN . "\n\n";

echo "2. Testing Role Labels:\n";
echo "   - " . UserRole::getLabel('admin') . "\n";
echo "   - " . UserRole::getLabel('owner') . "\n";
echo "   - " . UserRole::getLabel('bendahara') . "\n";
echo "   - " . UserRole::getLabel('pelanggan') . "\n\n";

echo "3. Testing Users from Database:\n";
$users = User::all();
echo "   Total Users: " . count($users) . "\n";
foreach ($users as $user) {
    echo "   - ID: {$user->id}, Email: {$user->email}, Role: {$user->role}\n";
}

echo "\n4. Testing User Model Helpers:\n";
$admin = User::where('role', 'admin')->first();
if ($admin) {
    echo "   Admin User ({$admin->email}):\n";
    echo "   - isAdmin(): " . ($admin->isAdmin() ? 'true' : 'false') . "\n";
    echo "   - canManageResources(): " . ($admin->canManageResources() ? 'true' : 'false') . "\n";
    echo "   - canManagePayments(): " . ($admin->canManagePayments() ? 'true' : 'false') . "\n";
    echo "   - canCreateBerita(): " . ($admin->canCreateBerita() ? 'true' : 'false') . "\n";
}

$bendahara = User::where('role', 'bendahara')->first();
if ($bendahara) {
    echo "\n   Bendahara User ({$bendahara->email}):\n";
    echo "   - isBendahara(): " . ($bendahara->isBendahara() ? 'true' : 'false') . "\n";
    echo "   - canManageResources(): " . ($bendahara->canManageResources() ? 'true' : 'false') . "\n";
    echo "   - canManagePayments(): " . ($bendahara->canManagePayments() ? 'true' : 'false') . "\n";
    echo "   - canCreateBerita(): " . ($bendahara->canCreateBerita() ? 'true' : 'false') . "\n";
}

$pelanggan = User::where('role', 'pelanggan')->first();
if ($pelanggan) {
    echo "\n   Pelanggan User ({$pelanggan->email}):\n";
    echo "   - isPelanggan(): " . ($pelanggan->isPelanggan() ? 'true' : 'false') . "\n";
    echo "   - canManageResources(): " . ($pelanggan->canManageResources() ? 'true' : 'false') . "\n";
    echo "   - canManagePayments(): " . ($pelanggan->canManagePayments() ? 'true' : 'false') . "\n";
    echo "   - canCreateBerita(): " . ($pelanggan->canCreateBerita() ? 'true' : 'false') . "\n";
}

echo "\n✅ Role implementation test completed!\n\n";
