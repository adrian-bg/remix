<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Interfaces\Authenticatable;

class ValidateAuthToken
{
    protected Authenticatable $authenticationService;

    public function __construct(Authenticatable $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $this->authenticationService->authenticate($request);

        if ($response) {
            $this->authenticationService->setUserData($response);

            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
