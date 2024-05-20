<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\Food;
use Carbon\Carbon;

class PlaceOrder extends Component
{
    use WithFileUploads;

    public $orderImage;
    public $cartItems = [];

    protected $rules = [
        'orderImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    public function mount()
    {
        $this->cartItems = Session::get('cart', []);
    }

    public function placeOrder()
    {
        $this->validate();

        if (empty($this->cartItems)) {
            Session::flash('error', 'Your cart is empty.');
            return redirect('/cart');
        }

        if ($this->orderImage) {
            $imageName = time() . '.' . $this->orderImage->getClientOriginalExtension();
            $this->orderImage->storeAs('images/orders', $imageName, 'public');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'date' => Carbon::now(),
            'image_path' => 'images/orders/' . $imageName,
        ]);

        $food_ids = array_column($this->cartItems, 'id');
        $valid_foods = Food::whereIn('id', $food_ids)->pluck('id')->toArray();

        foreach ($this->cartItems as $item) {
            if (in_array($item['id'], $valid_foods)) {
                $order->food()->attach($item['id'], ['quantity' => $item['quantity']]);
            } else {
                Session::flash('error', 'One or more food items in your cart are not available.');
                return redirect('/cart');
            }
        }

        Session::flash('success', 'Successfully placed order.');
        return redirect('/order');
    }

    public function render()
    {
        return view('livewire.order');
    }
}
