<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountTest extends TestCase
{

    use RefreshDatabase;

    public function test_account_creation_is_successful(): void
    {
        $userData = $this->getUserData();

        $response = $this->createAccount();
        $response->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'data' => [
                        'id',
                        'currency_id',
                        'user_id'
                    ],
                ]
            );

        $accountId = $response->getOriginalContent()['data']['id'];

        $this->assertTrue($response->getOriginalContent()['success']);
        $this->assertDatabaseHas('accounts', ['id' => $accountId, 'user_id' => $userData->get('id')]);
    }


}
