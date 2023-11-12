<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardTest extends TestCase
{
    use RefreshDatabase;

    public function test_card_creation_is_successful()
    {
        $cardData = $this->cardDataPayload();
        $response = $this->createCard();

        $response->assertStatus(200)
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
