<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Order;
use App\Models\Food;
use Carbon\Carbon;

class OrderTest extends TestCase
{
    protected $user;
    protected $food;

    public function setUp(): void
    {
        parent::setUp();
        
        // Create a user manually
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create a food item manually
        $this->food = Food::create([
            'name' => 'Test Food',
            'description' => 'A delicious test food item.',
            'price' => 9.99,
        ]);
    }



    public function testPlaceOrderWithEmptyCart()
    {
        // Act as the user
        $this->actingAs($this->user);
        
        // Mock the session to have an empty cart
        Session::put('cart', []);
        
        // Attempt to place an order
        $response = $this->post('/place-order', [
            'orderImage' => UploadedFile::fake()->image('order.jpg'),
        ]);

        // Assert that the user is redirected to the cart with an error
        $response->assertRedirect('/cart');
        $response->assertSessionHas('error', 'Your cart is empty.');
    }

    public function testPlaceOrderSuccessfully()
    {
        // Act as the user
        $this->actingAs($this->user);
        
        // Mock the session to have items in the cart
        Session::put('cart', [
            ['id' => $this->food->id, 'quantity' => 1],
        ]);

        // Mock the storage
        Storage::fake('public');
        
        // Attempt to place an order
        $response = $this->post('/place-order', [
            'orderImage' => UploadedFile::fake()->image('order.jpg'),
        ]);

        // Assert that the order was created
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
        ]);

        // Assert that the order food pivot table has the correct entry
        $order = Order::first();
        $this->assertDatabaseHas('food_order', [
            'order_id' => $order->id,
            'food_id' => $this->food->id,
            'quantity' => 1,
        ]);

        // Assert that the image was stored
        Storage::disk('public')->assertExists('images/orders/' . $order->image_path);

        // Assert that the user is redirected to the order page with a success message
        $response->assertRedirect('/order');
        $response->assertSessionHas('success', 'Successfully placed order.');
    }
}
