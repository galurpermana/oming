<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ingredient;

class IngredientControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_an_ingredient()
    {
        $user = User::factory()->create(); // Assuming you have a User factory

        $response = $this->actingAs($user)->post('/ingredient', [
            'name' => 'Test Ingredient',
            'stock' => 100,
            'harga_bahan' => 10000,
            'unit' => 'Gram',
            'priceunit' => 'Kilogram',
        ]);

        $response->assertRedirect(route('ingredient.index'));
        $response->assertSessionHas('success', 'Ingredient created successfully.');

        $this->assertDatabaseHas('ingredients', [
            'name' => 'Test Ingredient',
            'stock' => 100,
            'harga_bahan' => 10, // 10000 / 1000 for Kilogram conversion
            'unit' => 'Gram',
            'priceunit' => 'Kilogram',
        ]);
    }
}
