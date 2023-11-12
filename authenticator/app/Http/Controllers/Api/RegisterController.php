<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Register a user
     *
     * Attempts to add a new user to the resource and returns
     * the user's data with an OAuth2 token
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function store(RegisterRequest $request): JsonResponse
    {
        try {
            $user = new User($request->all());

            $user->save();

            return response()->json([
                'success' => true,
                'token' => $user->createToken('appToken')->accessToken,
                'user' => $user,
            ]);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Internal server error.',
            ], 500);
        }
    }

}
