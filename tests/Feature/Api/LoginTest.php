<?php

namespace Tests\Feature\Api;

use JWTAuth;
use Tests\TestCase;
use Acme\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginTest extends TestCase
{
    /** @test */
    public function user_can_log_in()
    {
        // arrange
        $user = create(User::class);

        // act
        $response = $this->postJson(route('api.login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        // assert
        $response->assertJsonFragment(['result' => 'success']);
        $response->assertStatus(201);
    }

    /** @test */
    public function user_cannot_log_in_with_invalid_credentials()
    {
        // act
        $response = $this->postJson(route('api.login'), [
            'email' => 'pippo@paperino.it',
            'password' => '123'
        ]);

        // assert
        $response->assertJsonFragment(['result' => 'error']);
        $response->assertStatus(401);
    }

    /** @test */
    public function login_can_throw_exception_if_something_else_goes_wrong()
    {
        JWTAuth::shouldReceive('attempt')->andThrow(new JWTException);

        $response = $this->postJson(route('api.login'));

        $response->assertStatus(500);
        $response->assertJsonFragment(['message' => 'general_error']);
    }
}
