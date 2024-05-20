<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function adminIndex() {
        $orders = Order::with(['user', 'food.ingredients'])->get();
        return view('order_admin.orderlist', ['orders' => $orders]);
    }


    public function create(Order $order)
    {
        $order->save();
    }

    public function addToOrder(Order $order)
    {
    }

    public function show()
    {
        $user_id = Auth::id();
        $orders = Order::where('user_id', $user_id)->orderBy('date', 'desc')->get();
        
        // To get total amount for each order:
        foreach($orders as $order) {
            $total = 0.0;

            foreach($order->food as $food) {
                $total += $food->price * $food->pivot->quantity;
            }
            
            $order->total = $total;
        }

        return view('order', ['orders' => $orders]);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        // For each food in the order:
        foreach ($order->food as $food){
            // Remove from pivot table
            $order->food()->detach($food->id);
        }
        $order->delete();
        // $order->food()->detach($food_id);
        Session::flash('success', 'Successfully deleted order from order history.');
        return redirect('/order');
    }

    public function updateCart(Request $req)
    {
        if(Auth::check()){
            if(Session::get('cart') == null) {
                Session::put('cart', array());
            }
            // $food = Food::findOrFail($req['id']);
            // $order->food()->attach($food, ['quantity' => $req['quantity']]);
            // $order->deliveryAddress = 'aaa';
    
            // Check if in the cart session array already has the same food_id in any of its sub-array's 'id' key.
            $foodExists = false;    // variable for whether that food exists in the cart session array
            
            // If have, need to add to that quantity, don't push a new array to the cart session array.
            if (is_array(Session::get('cart'))) {
                $cart_arr = Session::get('cart');
                $cart_id = -1;
                foreach ($cart_arr as $subarray) {
                    $cart_id++;
                    // Cart session array consists of subarrays.
                    // Check if array key 'id' is set and whether it is equals to $value that we put into the function
                    if (isset($subarray['id']) && $subarray['id'] == $req->id) {
                        // If true, set $foodExists to true.
                        $foodExists = true;
                        // Increment the food in the cart session array by the specified quantity.
                        Session::increment('cart.'.$cart_id.'.quantity', $req->quantity);
                        Session::save();
                        break;  // break out of this foreach loop
                    }
                }
    
                // If don't have, push a new array to the cart session array.
                if(!$foodExists) {
                    $food = [
                        'id' => $req->id,
                        'name' => $req->name,
                        'price' => $req->price,
                        'picture' => $req->picture,
                        'quantity' => $req->quantity,
                    ];
                    Session::push('cart', $food);
                }

                Session::flash('success', 'Successfully added to cart.');
            }

            return '/';
        }
        else {
            Session::flash('info', 'You must be logged in to add to cart and place orders.');
            return '/login';
        }
    }

    public function removeFromCart($id)
    {
        // Function that returns a new cart that doesn't include the food that is to be removed
        function getNewCart($array, $key, $value, $cart_id)
        {
            $cart_arr = array();
            $results = array();
            
            // check if it is an array
            if (is_array($array)) {
                
                foreach ($array as $subarray) {
                    $cart_id++;
                    // Cart session array consists of subarrays.
                    // Check if array key 'id' is set and whether it is equals to $value that we put into the function
                    if (isset($subarray[$key]) && $subarray[$key] == $value) {
                        // If true, assign this array to array $results
                        $subarray['cart_id'] = $cart_id;
                        $results[] = $subarray; // $results contains food that is to be deleted
                        break;  // break out of this foreach loop
                    }
                }
            }

            $cart_arr = $array;
            array_splice($cart_arr, $cart_id, 1);   // remove the item from the cart array
            return $cart_arr;
        }

        $new_cart_arr = getNewCart(Session::pull('cart'), 'id', $id, -1);
        Session::save();

        // Replace the existing array in the cart session with $new_cart_arr
        Session::put('cart', $new_cart_arr);
        
        Session::flash('success', 'Successfully removed from cart.');
        return redirect('/cart');
    }

    public function placeOrder(Request $req) {
        // Validate the uploaded image
        $req->validate([
            'orderImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Handle the file upload
        if ($req->hasFile('orderImage')) {
            $image = $req->file('orderImage');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/orders'), $imageName);
        }
    
        // Create a new order
        $order = Order::create([
            'user_id' => Auth::id(),
            'date' => Carbon::now(),
            'image_path' => 'images/orders/' . $imageName,
        ]);
    
        // Get the cart items from the session
        $cart_arr = Session::pull('cart');  // pull: get the value and removes it from the session
        
    
        // Check if the cart is empty
        if (is_null($cart_arr) || empty($cart_arr)) {
            Session::flash('error', 'Your cart is empty.');
            return redirect('/cart');  // Redirect back to the cart or show an error page
        }
    
        // Validate that all food IDs exist
        $food_ids = array_column($cart_arr, 'id');
        $valid_foods = Food::whereIn('id', $food_ids)->pluck('id')->toArray();
    
        foreach ($cart_arr as $item) {
            if (in_array($item['id'], $valid_foods)) {
                $order->food()->attach($item['id'], ['quantity' => $item['quantity']]);
            } else {
                // Handle the case where a food item is not valid
                Session::flash('error', 'One or more food items in your cart are not available.');
                return redirect('/cart');  // Redirect back to the cart or show an error page
            }
        }
    
        // Flash success message and redirect to orders page
        Session::flash('success', 'Successfully placed order.');
        return redirect('/order');
    }

    public function updateStatus(Request $request)
    {
        // Validate the request to ensure order_id and status are correct
        $request->validate([
            'order_id' => 'required|exists:order,id',
            'status' => 'required|string|in:pending,In Process,Rejected,Canceled,Completed',
        ]);

        // Retrieve the order with its related foods and ingredients
        $order = Order::with('food.ingredients')->findOrFail($request->order_id);
        $previousStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        // Log the order details for debugging
        Log::info('Order details', ['order' => $order->toArray()]);

        // Check if the status is changing to "In Process" from any other status
        if ($previousStatus !== 'In Process' && $request->status === 'In Process') {
            foreach ($order->food as $food) {
                foreach ($food->ingredients as $ingredient) {
                    $quantityUsed = $ingredient->pivot->quantity * $food->pivot->quantity;
                    $ingredient->stock -= $quantityUsed;
                    $ingredient->save();
                    Log::info('Reduced stock for ingredient', [
                        'ingredient_id' => $ingredient->id,
                        'quantity_used' => $quantityUsed,
                        'new_stock' => $ingredient->stock,
                    ]);
                }
            }
            
        }

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function cancelOrder(Request $request, $orderId)
    {
        try {
            // Retrieve the order
            $order = Order::findOrFail($orderId);

            // Update the status to "Canceled"
            $order->status = 'Canceled';
            $order->save();

            // Optionally, you can perform additional actions here, such as sending notifications, logging, etc.

            return redirect()->back()->with('success', 'Order canceled successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error canceling order: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to cancel order.');
        }
    }

}
