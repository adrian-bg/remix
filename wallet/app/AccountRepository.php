<?php

namespace App;

use App\Http\Requests\StoreAccountRequest;
use App\Interfaces\Authenticatable;
use App\Models\Account;

class AccountRepository
{

    protected Authenticatable $authenticationService;

    public function __construct(Authenticatable $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @param StoreAccountRequest $request
     * @return Account
     */
    public function createAccount(StoreAccountRequest $request): Account
    {
        $account = new Account();
        $account->setAttribute('currency_id', $request->get('currency_id'));

        $user = $this->authenticationService->getUserData();
        $account->setAttribute('user_id', $user->getId());

        $account->save();

        return $account;
    }

    /**
     * @param $id
     * @return Account
     */
    public function showAccount($id): Account
    {
        $user = $this->authenticationService->getUserData();

        return Account::where([
            'id' => $id,
            'user_id' => $user->getId()
        ])->first();
    }

    /**
     * @return mixed
     */
    public function getAccounts(): mixed
    {
        $user = $this->authenticationService->getUserData();

        return Account::where([
            'user_id' => $user->getId()
        ])->with('currency')->active()->get();
    }
}
