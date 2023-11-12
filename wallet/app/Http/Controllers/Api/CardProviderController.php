<?php

namespace App\Http\Controllers\Api;

use App\Models\CardProvider;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CardProviderController extends Controller
{

    /**
     * List the card providers
     *
     * Shows all available currencies
     *
     * @return JsonResponse
     * @response array{success:bool, data: CardProvider[]}
     */
    public function index(): JsonResponse
    {
        return response()->json(CardProvider::all());
    }
}
