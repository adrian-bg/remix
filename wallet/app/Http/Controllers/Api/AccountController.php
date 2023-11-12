<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Account;
use App\Http\Requests\{
    StoreAccountRequest,
    UpdateAccountRequest
};
use Illuminate\Http\JsonResponse;
use App\Interfaces\Authenticatable;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\AccountRepository;

class AccountController extends Controller
{

    /**
     * List the user accounts
     *
     * Attempts to show all accounts for the user from the OAuth2 Authorization header
     *
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     * @response array{success:bool, data: Account[]}
     */
    public function index(Authenticatable $authenticationService): JsonResponse
    {
        try {
            $accountRepository = new AccountRepository($authenticationService);

            return response()->json([
                'success' => true,
                'data' => $accountRepository->getAccounts(),
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
        }

        return response()->json([
            'success' => false
        ], 500);
    }

    /**
     * Create an account
     *
     * Attempts to create an account for the user from the OAuth2 Authorization header
     *
     * @param StoreAccountRequest $request
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     */
    public function store(StoreAccountRequest $request, Authenticatable $authenticationService): JsonResponse
    {
        try {
            $accountRepository = new AccountRepository($authenticationService);
            $account = $accountRepository->createAccount($request);

            if ($account) {
                return response()->json([
                    'success' => true,
                    'data' => $account
                ]);
            }
        } catch (Exception $exception) {
            Log::error($exception);
        }

        return response()->json(['success' => false], 500);
    }

    /**
     * Get an account
     *
     * Attempts to retrieve an account for the user from the OAuth2 Authorization header
     *
     * @param int $id
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     * @response array{success:bool, data: Account}
     */
    public function show(int $id, Authenticatable $authenticationService): JsonResponse
    {
        try {
            $accountRepository = new AccountRepository($authenticationService);

            return response()->json([
                'success' => true,
                'data' => $accountRepository->showAccount($id)
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
        }

        return response()->json(['success' => false], 500);
    }

    /**
     * Soft deletes an account
     *
     * Attempts to delete an account for the user from the OAuth2 Authorization header
     *
     * @param int $id
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     * @response array{success:bool}
     */
    public function destroy(int $id, Authenticatable $authenticationService): JsonResponse
    {
        try {
            $accountRepository = new AccountRepository($authenticationService);

            return response()->json([
                'success' => $accountRepository->destroyAccount($id) === 1,
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
        }

        return response()->json(['success' => false], 500);
    }

}
