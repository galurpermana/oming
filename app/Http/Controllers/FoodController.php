<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\FoodIngredient;
use App\Models\Ingredient;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreFoodRequest;

class FoodController extends Controller
{
    public function index()
    {
        if (request()->has('asc')) {
            if (request()->asc == 'true') {
                $foods = Food::orderBy('price')->orderBy('name')->paginate(12);
                // orderBy('name') so that for those foods with same price, it will sort alphabetically by their name
            }
            if (request()->asc == 'false') {
                $foods = Food::orderBy('price', 'DESC')->orderBy('name')->paginate(12);
            }
        } else {
            $foods = Food::paginate(12);
        }
        return view('food.home',  ['foods' => $foods]);
    }
    
    public function filter($type)
    {
        $foods = Food::where('type', '=', $type);

        if (request()->has('asc')) {
            if (request()->asc == 'true') {
                $sorted = $foods->orderBy('price');
            }
            if (request()->asc == 'false') {
                $sorted = $foods->orderBy('price', 'DESC');
            }
        } else {
            $sorted = $foods;        
        }
        return view('food.home',  ['foods' => $foods->paginate(12)]);
    }

    public function sortByPrice($type)
    {
        if ($type) {
            $foods = Food::orderBy('price')->paginate(12);
        } else {
            $foods = Food::orderByDesc('price')->paginate(12);
        }

        return view('food.home',  ['foods' => $foods]);
    }

    public function adminIndex()
    {
        $foods = Food::orderBy('id','desc')->paginate(10);
        return view('food.viewfood',  ['foods' => $foods]);
    }

    public function show($id)
    {
        $food = Food::findOrFail($id);
        return view('food.show', ['food' => $food]);
    }

    public function getForUpdate($id)
    {
        $food = Food::findOrFail($id);
        return view('food.updatefood', ['food' => $food]);
    }

    public function destroy($id)
    {
        $food = Food::findOrFail($id);
        $food->delete();
        return redirect('food/viewfood')->with('error', 'Food deleted successfully!');
        
    }

    public function create(Request $request)
    {
        $ingredients = Ingredient::all(); 
        return view('food.addfood', ['ingredients' => $ingredients]);
        
    }


    public function store(StoreFoodRequest $request)
    {
        // Define unit conversion rates
        $unitConversion = [
            'Gram' => 1,
            'Kilogram' => 1000, 
            'Liter' => 1, 
            
       ];


        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'picture' => 'required',
            'ingredients' => 'required|array',
            'ingredients.*.type',
            'ingredients.*.quantity',
            'ingredients.*.unit' ,
       ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Pass validation errors to the view
                ->withInput(); // Pass the input data back to the form
        }

        // Upload the image
        $imagePath = $request->file('picture')->store('foods', 'public');


        // Create food
        $food = Food::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'picture' => $imagePath,
        ]);

        // Attach ingredients to the food after converting quantities
        foreach ($request->ingredients as $ingredient) {
            // Convert quantity to a common unit
            $convertedQuantity = $ingredient['quantity'] * $unitConversion[$ingredient['unit']];

            FoodIngredient::create([
                'food_id' => $food->id,
                'ingredient_id' => $ingredient['type'],
                'quantity' => $convertedQuantity,
                'unit' => $ingredient['unit'], 
            ]);
        }

        // Redirect back or do whatever you want
        return redirect('food/viewfood')->with('success', 'Food created successfully!');
    }

    
    public function edit( $id) {
        $food = Food::findOrFail($id);
        $ingredients = Ingredient::all();
        return view('food.updatefood', ['food' => $food, 'ingredients' => $ingredients]);
    }
    

    public function update(Request $request, $id)
    {
        $unitConversion = [
            'Gram' => 1,
            'Kilogram' => 1000, 
            'Liter' => 1, 
        ];
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'picture' => 'image|max:2048',
            'ingredients.*.type' ,
            'ingredients.*.quantity' => 'required|numeric|min:0',
            'ingredients.*.unit' => 'required|string|max:255',
        ]);
        // dd($request->all());

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Pass validation errors to the view
                ->withInput(); // Pass the input data back to the form
        }

        // Update food
        $food = Food::findOrFail($id);
        $food->name = $request->name;
        $food->description = $request->description;
        $food->price = $request->price;
        $food->picture = $request->file('picture') ? $request->file('picture')->store('public/foods') : $food->picture;
        $food->save();

        // Update ingredients
        $foodIngredients = FoodIngredient::where('food_id', $id)->get();
        FoodIngredient::where('food_id', $id)->delete(); // Delete all current ingredients before adding new ones
        foreach ($request->ingredients as $ingredient) {
            // Convert quantity to a common unit
            $convertedQuantity = $ingredient['quantity'] * $unitConversion[$ingredient['unit']];
            
            FoodIngredient::create([
                'food_id' => $food->id,
                'ingredient_id' => $ingredient['type'],
                'quantity' => $convertedQuantity,
                'unit' => $ingredient['unit'], 
            ]);
        }

        // Redirect back or do whatever you want
        return redirect('/food/viewfood')->with('success', 'Food updated successfully!');
    }
    
    // public function showFoodCost($foodId)
    // {
    //     // Retrieve the food and its associated ingredients
        
    //     $foodIngredients = FoodIngredient::where('food_id', $foodId)->get();
    //     // dd($foodIngredients);

    //     // Calculate total cost for each ingredient
    //     $totalCost = 0;
    //     foreach ($foodIngredients as $foodIngredient) {
    //         $ingredient = $foodIngredient->ingredient;
    //         $ingredientCost = $ingredient->harga_bahan * $foodIngredient->quantity;
    //         $totalCost += $ingredientCost;
    //     }

    //     return view('food.viewfood', [
            
    //         'totalCost' => $totalCost,
    //         'foodIngredients' => $foodIngredients
    //     ]);
    // }

   
}
