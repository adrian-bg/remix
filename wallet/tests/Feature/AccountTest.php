<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{

    use RefreshDatabase;

    public function test_user_can_create_account_successfully(): void
    {
        $userData = $this->getUserData();

        $currency = Currency::first();

        $response = $this->withHeaders(['Authorization'=>'Bearer '. $userData->get('token')])
            ->post(config('app.api.test.url') . 'account', [
                'currency_id' => $currency->getAttribute('id')
            ])
            ->assertStatus(200)
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
