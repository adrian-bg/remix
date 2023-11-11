<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_successfully(): void
    {
        $userPayload = $this->registerPayload();

        $this->post(config('app.api.test.url') . 'register', $userPayload)
            ->assertStatus(200);

        $response = $this->post(config('app.api.test.url') . 'login', $userPayload)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'token',
                    'user' => [
                        'id',
                        'name',
                        'email'
                    ],
                ]
            );

        $this->assertTrue($response->getOriginalContent()['success']);
        $this->assertEquals($userPayload['name'], $response->getOriginalContent()['user']['name']);
        $this->assertEquals($userPayload['email'], $response->getOriginalContent()['user']['email']);
    }

    public function test_user_can_logout_successfully(): void
    {
        $userPayload = $this->registerPayload();

        $this->post(config('app.api.test.url') . 'register', $userPayload)
            ->assertStatus(200);

        unset($userPayload['name']);

        $loginResponse = $this->post(config('app.api.test.url') . 'login', $userPayload)
            ->assertStatus(200);

        $logoutResponse = $this->withHeaders(['Authorization'=>'Bearer '. $loginResponse->getOriginalContent()['token']])
            ->post(config('app.api.test.url') . 'logout')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'message'
                ]
            );

        $this->assertTrue($logoutResponse->getOriginalContent()['success']);
    }
}
