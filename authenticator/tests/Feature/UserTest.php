<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_user_successfully(): void
    {
        $userPayload = $this->registerPayload();

        $this->post(config('app.api.test.url') . 'register', $userPayload)
            ->assertStatus(200);

        $loginResponse = $this->post(config('app.api.test.url') . 'login', $userPayload)
            ->assertStatus(200);

        $getLoggedUserResponse = $this->withHeaders([
            'Authorization' => 'Bearer '. $loginResponse->getOriginalContent()['token']
        ])
            ->get(config('app.api.test.url') . 'user')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'message',
                    'user' => [
                        'id',
                        'name',
                        'email'
                    ]
                ]
            );

        $this->assertTrue($getLoggedUserResponse->getOriginalContent()['success']);
        $this->assertEquals('Token is valid', $getLoggedUserResponse->getOriginalContent()['message']);
        $this->assertEquals($userPayload['name'], $getLoggedUserResponse->getOriginalContent()['user']['name']);
        $this->assertEquals($userPayload['email'], $getLoggedUserResponse->getOriginalContent()['user']['email']);
    }
}
