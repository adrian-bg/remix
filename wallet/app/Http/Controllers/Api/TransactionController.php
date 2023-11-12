<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Interfaces\{
    HasPayments,
    Authenticatable
};
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CompleteTransactionRequest;

class TransactionController extends Controller
{

    /**
     * Complete a transaction
     *
     * Attempts to complete a transaction
     *
     * @param CompleteTransactionRequest $request
     * @param HasPayments $paymentService
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     */
    public function complete(CompleteTransactionRequest $request, HasPayments $paymentService, Authenticatable $authenticationService): JsonResponse
    {

        try {

            $paymentService->completeTransaction($request->get('transaction_id'), $request->get('status_id'));

            return response()->json(['success' => true]);
        } catch (Exception $exception) {
            Log::error($exception);

            return response()->json(['success' => false], 500);
        }
    }

}
