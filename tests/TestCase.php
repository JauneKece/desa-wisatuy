<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

/**
 * @method TestResponse post(string $uri, array $data = [], array $headers = [])
 * @method TestResponse postJson(string $uri, array $data = [], array $headers = [])
 * @method TestResponse get(string $uri, array $headers = [])
 * @method TestResponse getJson(string $uri, array $headers = [])
 * @method $this withoutMiddleware()
 */
abstract class TestCase extends BaseTestCase
{
    //
}
