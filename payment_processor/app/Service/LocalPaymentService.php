<?php

namespace App\Service;

use App\Interfaces\Payable;
use App\Jobs\NotifyWalletService;
use App\Events\NotifyWallet;
use App\Http\Requests\ProcessTransactionRequest;

class LocalPaymentService implements Payable
{

    public function processDebitTransaction(ProcessTransactionRequest $request): void
    {
        NotifyWalletService::dispatch($request->get('transaction_id'), config('app.output_statuses.completed'))
            ->delay(now()->addSeconds(5));
    }

    public function processCreditTransaction(ProcessTransactionRequest $request): void
    {
        NotifyWalletService::dispatch($request->get('transaction_id'), config('app.output_statuses.completed'))
            ->delay(now()->addSeconds(5));
    }
}
