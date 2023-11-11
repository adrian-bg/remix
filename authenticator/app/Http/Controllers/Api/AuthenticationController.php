<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use App\Http\Requests\{
    LoginRequest,
    LogoutRequest,
};
use Illuminate\Support\Facades\{
    Log,
    Auth
};
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{

    /**
     * Log a user
     *
     * Attempts to log a user in and returns
     * the user's data with an OAuth2 token
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')]);
            $user = User::find(Auth::user()->id);

            return response()->json([
                'success' => true,
                'token' => $user->createToken('appToken')->accessToken,
                'user' => $user,
            ]);

        } catch (Exception $exception) {
            Log::warning($exception->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);

        }
    }

    /**
     * Logout a user
     *
     * Attempts to log a user out from the OAuth2 Authorization header
     *
     * @param LogoutRequest $request
     * @return JsonResponse|void
     */
    public function destroy(LogoutRequest $request)
    {
        if (Auth::user()) {
            $request->user()->token()->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully',
            ], 200);
        }
    }

}
