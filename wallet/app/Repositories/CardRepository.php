<?php

namespace App\Repositories;

use App\Models\Card;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Authenticatable;
use App\Http\Requests\StoreCardRequest;
use Illuminate\Database\Eloquent\Collection;

class CardRepository
{

    protected Authenticatable $authenticationService;

    public function __construct(Authenticatable $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @param StoreCardRequest $request
     * @return ?Card
     */
    public function createCard(StoreCardRequest $request): ?Card
    {
        $user = $this->authenticationService->getUserData();

        return DB::transaction(function () use ($request, $user) {
            return Card::create([
                'user_id' => $user->getId(),
                'card_type_id' => $request->get('card_type_id'),
                'card_provider_id' => $request->get('card_provider_id'),
                'names' => $request->get('names'),
                'number' => $request->get('number'),
                'cvv' => $request->get('cvv'),
                'expire_at' => $request->get('expire_at'),
            ]);
        });
    }

    /**
     * @return Collection
     */
    public function getCards(): Collection
    {
        $user = $this->authenticationService->getUserData();

        return Card::where([
            'user_id' => $user->getId()
        ])->with(['cardType', 'CardProvider'])->get();
    }

    /**
     * @param int $id
     * @return Card|null
     */
    public function showCard(int $id): ?Card
    {
        $user = $this->authenticationService->getUserData();

        return Card::where([
            'id' => $id,
            'user_id' => $user->getId()
        ])
            ->with(['cardType', 'CardProvider'])
            ->first();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroyCard(int $id): mixed
    {
        $user = $this->authenticationService->getUserData();

        return Card::where([
            'id' => $id,
            'user_id' => $user->getId()
        ])->delete();
    }

}
