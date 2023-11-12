<?php

namespace App\Http\Controllers\Api;

use App\Interfaces\Payable;
use App\Repositories\PaymentRepository;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProcessTransactionRequest;
use Illuminate\Support\Facades\Log;

class TransactionProcessorController extends Controller
{

    /**
     * Process a transaction
     *
     * Attempts to process a transaction
     *
     * @param ProcessTransactionRequest $request
     * @param Payable $paymentService
     * @return JsonResponse
     */
    public function processTransaction(ProcessTransactionRequest $request, Payable $paymentService): JsonResponse
    {

        try {
            $repository = new PaymentRepository();
            $repository->process($request, $paymentService);

            return response()->json(['success' => true]);
        } catch (\Exception $exception) {
            Log::error($exception);

        }

        return response()->json(['success' => false], 500);
    }

}
