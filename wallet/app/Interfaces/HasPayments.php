<?php

namespace App\Interfaces;

use App\Exceptions\{
    PaymentServiceException,
    CardRepositoryException,
    AccountRepositoryException,
};
use App\Models\Transaction;
use App\Http\Requests\TransactionRequest;

interface HasPayments
{

    /**
     * @param TransactionRequest $request
     * @param int $transactionTypeId
     * @param Authenticatable $authenticationService
     * @return ?Transaction
     * @throws AccountRepositoryException
     * @throws CardRepositoryException
     * @throws PaymentServiceException
     */
    public function createTransaction(TransactionRequest $request, int $transactionTypeId, Authenticatable $authenticationService): ?Transaction;

    /**
     * @param int $transactionId
     * @param int $statusId
     * @return void
     * @throws PaymentServiceException
     */
    public function completeTransaction(int $transactionId, int $statusId): void;

    /**
     * @param Transaction $transaction
     * @param TransactionRequest $request
     * @return void
     * @throws PaymentServiceException
     */
    public function processTransaction(Transaction $transaction, TransactionRequest $request): void;

    /**
     * @param Transaction $transaction
     * @param int $statusId
     * @return void
     */
    public function completeDepositTransaction(Transaction $transaction, int $statusId): void;

    /**
     * @param Transaction $transaction
     * @param int $statusId
     * @return void
     */
    public function completeWithdrawTransaction(Transaction $transaction, int $statusId): void;

}
