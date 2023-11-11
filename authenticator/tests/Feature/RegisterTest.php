<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_registered_successfully(): void
    {
        $userPayload = $this->registerPayload();

        $response = $this->post(config('app.api.test.url') . 'register', $userPayload)
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

        unset($userPayload['password']);

        $this->assertDatabaseHas('users', $userPayload);
    }

}
