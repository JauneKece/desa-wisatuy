<?php

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can send notification directly', function () {
    Notification::fake();
    
    $user = User::factory()->create();
    
    // Test 1: Send notification directly
    $user->notify(new ResetPassword('test-token-123'));
    
    // Check if notification was sent
    Notification::assertSentTo($user, ResetPassword::class);
    
    expect(Notification::sent($user, ResetPassword::class)->count())->toBe(1);
});
