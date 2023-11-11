<?php

namespace App\Http\Controllers\Api;

use App\AccountRepository;
use Illuminate\Http\JsonResponse;
use App\Interfaces\Authenticatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountRequest;

class AccountController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     */
    public function index(Authenticatable $authenticationService): JsonResponse
    {
        $accountRepository = new AccountRepository($authenticationService);

        return response()->json($accountRepository->getAccounts());
    }

    /**
     * Store a newly created resource in storage
     *
     * @param StoreAccountRequest $request
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     */
    public function store(StoreAccountRequest $request, Authenticatable $authenticationService): JsonResponse
    {
        $accountRepository = new AccountRepository($authenticationService);

        return response()->json($accountRepository->createAccount($request));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     */
    public function show(int $id, Authenticatable $authenticationService): JsonResponse
    {
        $accountRepository = new AccountRepository($authenticationService);

        return response()->json($accountRepository->showAccount($id));
    }

    /**
     * Update the specified resource from storage.
     *
     * @param string $id
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     */
    public function update(string $id, Authenticatable $authenticationService): JsonResponse
    {
        $accountRepository = new AccountRepository($authenticationService);

        return response()->json($accountRepository->showAccount($id));
    }
}
