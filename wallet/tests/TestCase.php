<?php

namespace Tests;

use App\Models\{
    CardType,
    Currency,
    CardProvider
};
use Illuminate\Support\Facades\{
    Http,
    Artisan
};
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

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

    /**
     * @return TestResponse
     */
    protected function createAccount(): TestResponse
    {
        $userData = $this->getUserData();
        $currency = Currency::first();

        return $this->withHeaders(['Authorization' => 'Bearer '. $userData->get('token')])
            ->post(config('app.api.test.url') . 'account', [
                'currency_id' => $currency->getAttribute('id')
            ]);
    }

    protected function createCard(): TestResponse
    {
        $userData = $this->getUserData();
        $cardData = $this->cardDataPayload();

        return $this->withHeaders(['Authorization' => 'Bearer '. $userData->get('token')])
            ->post(config('app.api.test.url') . 'card', $cardData);
    }

    /**
     * @return array
     */
    protected function cardDataPayload(): array
    {
        $userData = $this->getUserData();
        $cardType = CardType::first();
        $cardProvider = CardProvider::first();

        return [
            'card_type_id' => $cardType->getAttribute('id'),
            'card_provider_id' => $cardProvider->getAttribute('id'),
            'names' => $userData->get('name'),
            'number' => '123123123',
            'cvv' => '123',
            'expire_at' => now()->addYears(2)->format('Y-d')
        ];
    }

}
