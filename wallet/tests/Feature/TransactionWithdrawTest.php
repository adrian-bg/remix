<?php

namespace Tests\Feature;

use App\Models\{Account, TransactionType, TransactionStatus};
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionWithdrawTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_transaction_withdraw_creation_is_successful(): void
    {
        $userData = $this->getUserData();
        $accountResponse = $this->createAccount();
        $cardResponse = $this->createCard();

        $accountId = $accountResponse->getOriginalContent()['data']['id'];
        $cardId = $cardResponse->getOriginalContent()['data']['id'];

        //add 1000 to user balance
        $account = Account::find($accountId);
        $account->setAttribute('balance', 1000);
        $account->save();

        $transactionWithdraw = [
            'account_id' => $accountId,
            'card_id' => $cardId,
            'amount' => 500
        ];

        $responseWithdraw = $this->withHeaders(['Authorization' => 'Bearer '. $userData->get('token')])
            ->post(config('app.api.test.url') . 'transaction-withdraw', $transactionWithdraw)
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

        $this->assertTrue($responseWithdraw->getOriginalContent()['success']);

        $transactionData['id'] = $responseWithdraw->getOriginalContent()['data']['id'];
        $transactionData['transaction_type_id'] = TransactionType::WITHDRAWAL_TYPE;
        $transactionData['transaction_status_id'] = TransactionStatus::TRANSACTION_STATUS_PENDING;

        $this->assertDatabaseHas('transactions', $transactionData);
    }
}
