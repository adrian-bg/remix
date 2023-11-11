<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\{
    Log,
    Auth
};
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShowUserRequest;


class UserController extends Controller
{

    /**
     * Get a user
     *
     * Attempts to retrieve the user's data from the OAuth2 Authorization header
     *
     * @param ShowUserRequest $request
     * @return JsonResponse
     */
    public function show(ShowUserRequest $request): JsonResponse
    {
        try {
            if (Auth::user()) {
                $user = User::find(Auth::user()->id);

                return response()->json([
                    'success' => true,
                    'message' => 'Token is valid',
                    'user' => $user->toArray()
                ], 200);
            }

        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated.',
        ], 401);
    }
}
