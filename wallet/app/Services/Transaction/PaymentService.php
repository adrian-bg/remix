<?php

namespace App\Services\Transaction;

use App\Models\{
    Transaction,
    TransactionStatus,
    TransactionType
};
use App\Exceptions\{
    CardRepositoryException,
    AccountRepositoryException,
    PaymentServiceException
};
use App\Interfaces\{
    HasPayments,
    Authenticatable
};
use App\Repositories\{
    CardRepository,
    AccountRepository
};
use Illuminate\Support\Facades\{
    DB,
    Http
};
use App\Http\Requests\TransactionRequest;

class PaymentService implements HasPayments
{

    /**
     * @inheritDoc
     */
    public function createTransaction(TransactionRequest $request, int $transactionTypeId, Authenticatable $authenticationService): ?Transaction
    {
        $this->checkAccount($request->get('account_id'), $authenticationService);
        $this->checkCard($request->get('card_id'), $authenticationService);
        $this->checkType(
            $transactionTypeId,
            $request->get('account_id'),
            $request->get('amount'),
            $authenticationService
        );

        return DB::transaction(function () use ($request, $transactionTypeId) {
            $transaction = Transaction::create([
                'account_id' => $request->get('account_id'),
                'card_id' => $request->get('card_id'),
                'transaction_type_id' => $transactionTypeId,
                'transaction_status_id' => TransactionStatus::TRANSACTION_STATUS_PENDING,
                'amount' => $request->get('amount')
            ]);

            $this->processTransaction($transaction, $request);

            return $transaction;
        });
    }

    /**
     * @inheritDoc
     */
    public function completeTransaction(int $transactionId, int $statusId): void
    {
        $transaction = Transaction::where('id', $transactionId)
            ->whereNotIn('transaction_status_id', [TransactionStatus::TRANSACTION_STATUS_COMPLETED, TransactionStatus::TRANSACTION_STATUS_CANCELED])
            ->first();

        if (!$transaction) {
            throw new PaymentServiceException(__('exceptions.complete_transaction_not_found'), PaymentServiceException::COMPLETE_TRANSACTION_NOT_FOUND_CODE);
        }

        switch($transaction->getAttribute('')) {
            case TransactionType::DEPOSIT_TYPE:
                $this->completeDepositTransaction($transaction, $statusId);

                break;
            case TransactionType::WITHDRAWAL_TYPE:
                $this->completeWithdrawTransaction($transaction, $statusId);

                break;
            default:
                throw new PaymentServiceException(__('exceptions.incorrect_transaction_type'), PaymentServiceException::INCORRECT_TRANSACTION_TYPE_CODE);
        }
    }



    /**
     * @inheritDoc
     */
    public function processTransaction(Transaction $transaction, TransactionRequest $request): void
    {
        $response = Http::withHeaders([
            'Authorization' => $request->header('Authorization'),
            'Accept' => 'application/json'
        ])->post(config('services.payment_processor.url') . 'transaction/process', [
            'transaction_id' => $transaction->getAttribute('id'),
            'amount' => $transaction->getAttribute('amount'),
            'type' => TransactionType::PAYMENT_TYPE[$transaction->getAttribute('transaction_type_id')],
        ]);

        if (!$response->ok()) {
            throw new PaymentServiceException(__('exceptions.payment_communication_error'), PaymentServiceException::COMMUNICATION_ERROR_CODE);
        }
    }

    /**
     * @inheritDoc
     */
    public function completeDepositTransaction(Transaction $transaction, $statusId): void
    {
        $transaction->load('account');

        $amount = $transaction->getAttribute('amount');
        $account = $transaction->getAttribute('account');
        $balance = $account->getAttribite('balance');

        $account->setAttribute('balance', bcadd($amount, $balance, 2));
        $account->save();
    }

    /**
     * @inheritDoc
     */
    public function completeWithdrawTransaction(Transaction $transaction, $statusId): void
    {
        $transaction->load('account');

        $amount = $transaction->getAttribute('amount');
        $account = $transaction->getAttribute('account');
        $balance = $account->getAttribite('balance');

        $account->setAttribute('balance', bcsub($balance, $amount, 2));
        $account->save();
    }

    /**
     * @param int $accountId
     * @param Authenticatable $authenticationService
     * @return void
     * @throws AccountRepositoryException
     */
    private function checkAccount(int $accountId, Authenticatable $authenticationService): void
    {
        $accountRepository = new AccountRepository($authenticationService);
        $account = $accountRepository->showAccount($accountId);
        if (!$account) {
            throw new AccountRepositoryException( __('exceptions.account_not_found'), AccountRepositoryException::ACCOUNT_NOT_FOUND_CODE);
        }
    }

    /**
     * @param int $cardId
     * @param Authenticatable $authenticationService
     * @return void
     * @throws CardRepositoryException
     */
    private function checkCard(int $cardId, Authenticatable $authenticationService): void
    {
        $cardRepository = new CardRepository($authenticationService);
        $card = $cardRepository->showCard($cardId);

        if (!$card) {
            throw new CardRepositoryException(__('exceptions.card_not_found'), CardRepositoryException::CARD_NOT_FOUND_CODE);
        }
    }

    /**
     * @param int $typeId
     * @param int $accountId
     * @param float $amount
     * @param Authenticatable $authenticationService
     * @return void
     * @throws AccountRepositoryException
     */
    private function checkType(int $typeId, int $accountId, float $amount, Authenticatable $authenticationService): void
    {
        if ($typeId === TransactionType::WITHDRAWAL_TYPE) {
            $accountRepository = new AccountRepository($authenticationService);

            $account = $accountRepository->showAccount($accountId);
            if ($account->getAttribute('balance') < $amount) {
                throw new AccountRepositoryException(__('exceptions.insufficient_funds'), AccountRepositoryException::INSUFFICIENT_FUNDS_CODE);
            }
        }
    }
}
