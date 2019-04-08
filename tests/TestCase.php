<?php

namespace Tests;

use JWTAuth;
use Acme\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $token;
    protected $apiUser;

    public function setUp() : void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    public function signIn($user = null)
    {
        $this->actingAs($user ?? create(User::class));

        return $this;
    }

    public function signInApi($user = null)
    {
        $user =  create(User::class);

        $this->token = JWTAuth::fromUser($user);
        $this->apiUser = $user;

        return $this;
    }

    public function apiCall($method, $url, $payload = [])
    {
        return $this->json($method, $url, $payload, ['Authorization' => 'Bearer ' . $this->token]);
    }
}
