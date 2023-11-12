<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Card;
use App\Interfaces\Authenticatable;
use App\Repositories\CardRepository;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCardRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

class CardController extends Controller
{

    /**
     * Create a card
     *
     * Attempts to create a card for the user from the OAuth2 Authorization header
     *
     * @param StoreCardRequest $request
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     */
    public function store(StoreCardRequest $request, Authenticatable $authenticationService): JsonResponse
    {
        try {
            $repository = new CardRepository($authenticationService);
            $card = $repository->createCard($request);

            if ($card) {
                return response()->json([
                    'success' => true,
                    'data' => $card
                ]);
            }
        } catch (Exception $exception) {
            Log::error($exception);
        }

        return response()->json(['success' => false], 500);
    }

    /**
     * Get a card
     *
     * Attempts to retrieve a for the user from the OAuth2 Authorization header
     *
     * @param int $id
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     * @response array{success:bool, data: Card}
     */
    public function show(int $id, Authenticatable $authenticationService): JsonResponse
    {
        try {
            $repository = new CardRepository($authenticationService);

            return response()->json([
                'success' => true,
                'data' => $repository->showCard($id)
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
        }

        return response()->json(['success' => false], 500);
    }

    /**
     * List the user cards
     *
     * Attempts to show all cards for the user from the OAuth2 Authorization header
     *
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     * @response array{success:bool, data: Card[]}
     */
    public function index(Authenticatable $authenticationService): JsonResponse
    {
        try {
            $repository = new CardRepository($authenticationService);

            return response()->json([
                'success' => true,
                'data' => $repository->getCards(),
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
        }

        return response()->json([
            'success' => false
        ], 500);
    }

    /**
     * Soft deletes a card
     *
     * Attempts to delete a card for the user from the OAuth2 Authorization header
     *
     * @param int $id
     * @param Authenticatable $authenticationService
     * @return JsonResponse
     * @response array{success:bool}
     */
    public function destroy(int $id, Authenticatable $authenticationService): JsonResponse
    {
        try {
            $repository = new CardRepository($authenticationService);

            return response()->json([
                'success' => $repository->destroyCard($id) === 1,
            ]);
        } catch (Exception $exception) {
            Log::error($exception);
        }
        return response()->json();
    }
}
