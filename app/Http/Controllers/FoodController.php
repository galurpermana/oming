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
        return redirect('/food/viewfood');
    }

    public function create(Request $request)
    {
        $ingredients = Ingredient::all(); 
        return view('food.addfood', ['ingredients' => $ingredients]);
    }


    public function store(Request $request)

    {
         
    //    dd($request->all());
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'picture' => 'required|image|max:2048', 
            // 'ingredients.*.type' => 'required',
            'ingredients.*.quantity' => 'required|numeric|min:1',
            'ingredients.*.unit' => 'required|string|max:255',
        ]);
        
   
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Pass validation errors to the view
                ->withInput(); // Pass the input data back to the form
                
                
        }
       
    
        // Upload the image
        $imagePath = $request->file('picture')->store('public/foods');
    
        // Create food
        $food = Food::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'picture' => $imagePath,
        ]);
        
    
        
        // Attach ingredients to the food
        foreach ($request->ingredients as $ingredient) {
            FoodIngredient::create([
                'food_id' => $food->id,
                'ingredient_id' => $ingredient['type'],
                'quantity' => $ingredient['quantity'],
                'unit' => $ingredient['unit'],
            ]);
        }
        // dd($food->fresh()->load('ingredients'));
    
        // Redirect back or do whatever you want
        return redirect('food/viewfood')->with('success', 'Food created successfully!');

    }
    

    

    public function update(Request $food, $id)
    {
        $food->validate([
            'name' => [
                'required',
                 Rule::unique('food')->ignore($id),
            ],
            'description' => 'required',
            'price' => 'required',
            'type' => 'required',
            'picture' => 'required'
        ]);
        Food::where('id', $id)->update([
            'name' => $food['name'],
            'description' => $food['description'],
            'price' => $food['price'],
            'type' => $food['type'],
            'picture' => $food['picture'],
        ]);
        return redirect('/food/viewfood');
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
