<?php

namespace Tests\Feature;

use App\Models\CardProvider;
use App\Models\CardType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CardTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_card_successfully()
    {
        $userData = $this->getUserData();
        $cardType = CardType::first();
        $cardProvider = CardProvider::first();

        $cardData = [
            'card_type_id' => $cardType->getAttribute('id'),
            'card_provider_id' => $cardProvider->getAttribute('id'),
            'names' => $userData->get('name'),
            'number' => '123123123',
            'cvv' => '123',
            'expire_at' => now()->addYears(2)->format('Y-d')
        ];

        $response = $this->withHeaders(['Authorization'=>'Bearer '. $userData->get('token')])
            ->post(config('app.api.test.url') . 'card', $cardData)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'success',
                    'data' => [
                        'id',
                        'user_id',
                        'card_type_id',
                        'card_provider_id',
                        'names',
                        'number',
                        'cvv',
                    ],
                ]
            );

        $this->assertTrue($response->getOriginalContent()['success']);
        $this->assertDatabaseHas('cards', $cardData);
    }

}
