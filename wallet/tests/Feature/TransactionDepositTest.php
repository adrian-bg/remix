<?php

namespace Tests\Feature;

use App\Models\{
    TransactionType,
    TransactionStatus
};
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionDepositTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_transaction_deposit_creation_is_successful(): void
    {
        $userData = $this->getUserData();
        $accountResponse = $this->createAccount();
        $cardResponse = $this->createCard();

        $transactionData = [
            'account_id' => $accountResponse->getOriginalContent()['data']['id'],
            'card_id' => $cardResponse->getOriginalContent()['data']['id'],
            'amount' => 1000
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer '. $userData->get('token')])
            ->post(config('app.api.test.url') . 'transaction-deposit', $transactionData)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'data' => [
                        'id',
                        'account_id',
                        'card_id',
                        'transaction_type_id',
                        'transaction_status_id',
                        'amount',
                    ],
                ]
            );

        $this->assertTrue($response->getOriginalContent()['success']);

        $transactionData['id'] = $response->getOriginalContent()['data']['id'];
        $transactionData['transaction_type_id'] = TransactionType::DEPOSIT_TYPE;
        $transactionData['transaction_status_id'] = TransactionStatus::TRANSACTION_STATUS_PENDING;

        $this->assertDatabaseHas('transactions', $transactionData);
    }
}
