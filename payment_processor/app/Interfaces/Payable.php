<?php

namespace App\Interfaces;

use App\Http\Requests\ProcessTransactionRequest;

interface Payable
{
    public function processDebitTransaction(ProcessTransactionRequest $request): void;

    public function processCreditTransaction(ProcessTransactionRequest $request): void;

}
