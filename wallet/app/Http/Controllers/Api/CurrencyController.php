<?php

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{

    /**
     * List the currencies
     *
     * Shows all available currencies
     *
     * @return JsonResponse
     * @response array{success:bool, data: Currency[]}
     */
    public function index(): JsonResponse
    {
        return response()->json(Currency::all());
    }
}
