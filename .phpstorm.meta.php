<?php
// .phpstorm.meta.php - PHPStorm metadata for better IDE support
// This file helps IDE understand Laravel's test framework methods

namespace PHPSTORM_META {
    use Illuminate\Foundation\Testing\TestCase;
    use Illuminate\Testing\TestResponse;
    
    // TestCase methods return $this for chaining
    expectedReturnValues(
        TestCase::withoutMiddleware(),
        \Tests\TestCase::class
    );
    
    expectedReturnValues(
        TestCase::withHeaders(),
        \Tests\TestCase::class
    );
}
