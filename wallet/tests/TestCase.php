<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private Collection $userData;

    public function setUp(): void
    {
        parent::setUp();

        $this->userData = collect();

        Artisan::call('migrate --env=testing');
    }

    /**
     * @return array
     */
    protected function registerPayload(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password123!'
        ];
    }

    protected function getUserData(): Collection
    {
        if ($this->userData->isEmpty()) {

            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])
                ->post(config('services.authenticator.url') . 'register', $this->registerPayload());
            $responseBody = json_decode($response->body(), true);

            if (is_array($responseBody) && array_key_exists('token', $responseBody)) {
                $this->userData->put('token', $responseBody['token']);
                $this->userData->put('id', $responseBody['user']['id']);
                $this->userData->put('name', $responseBody['user']['name']);
            }
        }

        return $this->userData;
    }
}
