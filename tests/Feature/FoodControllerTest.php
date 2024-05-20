<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Food;
use App\Models\Ingredient;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FoodControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_food_with_ingredients()
    {
        Storage::fake('public');

        $user = User::factory()->create(); // Assuming you have a User factory

        $ingredient = Ingredient::factory()->create(); // Create an Ingredient using the factory

        $response = $this->actingAs($user)->post('/food', [
            'name' => 'Test Food',
            'description' => 'Test Description',
            'price' => 100,
            'picture' => UploadedFile::fake()->image('food.jpg'),
            'ingredients' => [
                [
                    'type' => $ingredient->id,
                    'quantity' => 200,
                    'unit' => 'Gram'
                ],
            ],
        ]);

        $response->assertRedirect('food/viewfood');
        $response->assertSessionHas('success', 'Food created successfully!');

        $this->assertDatabaseHas('foods', [
            'name' => 'Test Food',
            'description' => 'Test Description',
            'price' => 100,
        ]);

        $this->assertDatabaseHas('food_ingredients', [
            'food_id' => Food::first()->id,
            'ingredient_id' => $ingredient->id,
            'quantity' => 200,
            'unit' => 'Gram',
        ]);

        $food = Food::first();
        Storage::disk('public')->assertExists($food->picture);
    }
}
