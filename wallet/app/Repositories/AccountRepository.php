<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Authenticatable;
use App\Http\Requests\StoreAccountRequest;
use Illuminate\Database\Eloquent\Collection;

class AccountRepository
{

    protected Authenticatable $authenticationService;

    public function __construct(Authenticatable $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @param StoreAccountRequest $request
     * @return ?Account
     */
    public function createAccount(StoreAccountRequest $request): ?Account
    {
        $user = $this->authenticationService->getUserData();

        return DB::transaction(function () use ($request, $user) {
            return Account::create([
                'currency_id' => $request->get('currency_id'),
                'user_id' => $user->getId(),
            ]);
        });
    }

    /**
     * @param $id
     * @return ?Account
     */
    public function showAccount($id): ?Account
    {
        $user = $this->authenticationService->getUserData();

        return Account::where([
            'id' => $id,
            'user_id' => $user->getId()
        ])->with('currency')->first();
    }

    /**
     * @return Collection
     */
    public function getAccounts(): Collection
    {
        $user = $this->authenticationService->getUserData();

        return Account::where([
            'user_id' => $user->getId()
        ])->with('currency')->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroyAccount(int $id): mixed
    {
        $user = $this->authenticationService->getUserData();

        return Account::where([
            'id' => $id,
            'user_id' => $user->getId()
        ])->delete();
    }

}
