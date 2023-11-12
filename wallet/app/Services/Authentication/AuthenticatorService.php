<?php

namespace App\Services\Authentication;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Log,
    Http
};
use App\Interfaces\Authenticatable;
use App\Helpers\AuthenticatedUserData;

class AuthenticatorService implements Authenticatable
{

    protected AuthenticatedUserData $userData;

    /**
     * @param Request $request
     * @return array|false|mixed
     */
    public function authenticate(Request $request): mixed
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $request->header('Authorization'),
                'Accept' => 'application/json'
            ])->get(config('services.authenticator.url') . 'user');

            if ($response && $response->ok()) {
                return $response->json();
            }
        } catch (Exception $exception) {
            Log::error($exception);
        }

        return false;
    }

    /**
     * @param array $data
     * @return void
     */
    public function setUserData(array $data): void
    {
        $this->userData = new AuthenticatedUserData();
        $this->userData
            ->setId($data['user']['id'])
            ->setName($data['user']['name'])
            ->setEmail($data['user']['email']);
    }

    /**
     * @return ?AuthenticatedUserData
     */
    public function getUserData(): ?AuthenticatedUserData
    {
        try {
            return $this->userData;
        } catch (Exception $exception) {
            Log::error($exception);
            return null;
        }
    }
}
