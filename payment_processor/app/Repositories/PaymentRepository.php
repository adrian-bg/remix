<?php

namespace App\Repositories;

use App\Interfaces\Payable;
use Illuminate\Support\Facades\Http;
use App\Exceptions\PaymentException;
use App\Http\Requests\ProcessTransactionRequest;

class PaymentRepository
{

    /**
     * @param ProcessTransactionRequest $request
     * @param Payable $paymentService
     * @return void
     * @throws PaymentException
     */
    public function process(ProcessTransactionRequest $request, Payable $paymentService): void
    {
        switch($request->get('type')) {
            case config('app.transaction_types.debit'):

                $paymentService->processDebitTransaction($request);

                break;
            case config('app.transaction_types.credit'):

                $paymentService->processCreditTransaction($request);

                break;
            default:

                throw new PaymentException(__('exceptions.incorrect_transaction_type'), PaymentException::INCORRECT_TRANSACTION_TYPE);
        }
    }

    /**
     * Sends request to complete a transaction to the wallet service
     *
     * @param int $transactionId
     * @param int $statusId
     * @return void
     */
    public static function notifyWallet(int $transactionId, int $statusId): void
    {
        Http::withHeaders([
            'Accept' => 'application/json'
        ])->post(config('services.wallet.complete_transaction_url'), [
            'transaction_id' => $transactionId,
            'status_id' => $statusId,
        ]);
    }


}
