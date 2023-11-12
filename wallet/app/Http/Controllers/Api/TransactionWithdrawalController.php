<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Exceptions\{
    CardRepositoryException,
    PaymentServiceException,
    AccountRepositoryException
};
use App\Interfaces\{
    HasPayments,
    Authenticatable
};
use App\Models\TransactionType;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\TransactionRequest;

class TransactionWithdrawalController extends Controller
{

    /**
     * Create a withdraw
     *
     * Attempts to create a withdraw for the user from the OAuth2 Authorization header
     *
     * @param TransactionRequest $request
     * @param HasPayments $paymentService
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     */
    public function store(TransactionRequest $request, HasPayments $paymentService, Authenticatable $authenticationService): JsonResponse
    {

        try {
            $transaction = $paymentService->createTransaction(
                $request,
                TransactionType::WITHDRAWAL_TYPE,
                $authenticationService
            );

            return response()->json(['success' => true, 'data' => $transaction]);
        } catch (Exception $exception) {
            Log::error($exception);

            return match (true) {
                $exception instanceof AccountRepositoryException,
                    $exception instanceof PaymentServiceException,
                    $exception instanceof CardRepositoryException
                => response()->json(['success' => false, 'message' => $exception->getMessage()], 422),
                default => response()->json(['success' => false], 500),
            };
        }
    }

}
