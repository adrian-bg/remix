<?php

namespace App\Http\Controllers\Api;

use App\Models\CardType;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CardTypeController extends Controller
{

    /**
     * List the card types
     *
     * Shows all available currencies
     *
     * @return JsonResponse
     * @response array{success:bool, data: CardType[]}
     */
    public function index(): JsonResponse
    {
        return response()->json(CardType::all());
    }
}
