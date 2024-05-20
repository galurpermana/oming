<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class IngredientsController extends Controller
{
    public function index()
    {
        $ingredient = Ingredient::all();
        return view('ingredient.ingredientslist', compact('ingredient'));
    }

    public function create()
    {
        return view('ingredient.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients',
            'stock' => 'required|numeric',
            'harga_bahan' => 'required|numeric',
            'unit' => 'required|string|max:255',
        ]);
    
        // Convert stock to grams
        $stock = $request->stock;
        $unit = $request->unit;
    
        switch ($unit) {
            case 'Kilogram':
                $stock *= 1000; // Convert kilograms to grams
                break;
            case 'Liter':
                // Assuming 1 liter equals 1000 milliliters
                $stock *= 1000; // Convert liters to milliliters
                break;
            // Add more cases for other units if needed
        }
    
        // Store the converted stock in common unit (grams)
        $request->merge([
            'stock' => $stock,
        ]);
    
        // Calculate the price per common unit
        $price = $request->harga_bahan;
        $pricePerUnit = $price / 1000;
    
        // Store the calculated price per common unit in harga_bahan
        $request->merge([
            'harga_bahan' => $pricePerUnit,
        ]);
    
        // Create the ingredient
        Ingredient::create($request->all());
    
        return redirect()->route('ingredient.index')->with('success', 'Ingredient created successfully.');
    }
    
    
    

    public function edit( $id)
    {
        $ingredient = Ingredient::find($id); // Fetch the ingredient by ID
        return view('ingredient.edit', compact('ingredient'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name,' . $id,
            'stock' => 'required|numeric',
            'harga_bahan' => 'required|numeric',
            'unit' => 'required|string|max:255',
        ]);
    
        // Convert stock to grams or milliliters based on the unit
        $stock = $request->stock;
        $unit = $request->unit;
    
        switch ($unit) {
            case 'Kilogram':
                $stock *= 1000; // Convert kilograms to grams
                break;
            case 'Liter':
                // Assuming 1 liter equals 1000 milliliters
                $stock *= 1000; // Convert liters to milliliters
                break;
            // Add more cases for other units if needed
        }
    
        // Store the converted stock in common unit (grams or milliliters)
        $request->merge([
            'stock' => $stock,
        ]);
    
        // Calculate the price per common unit
        $price = $request->harga_bahan;
        $pricePerUnit = $price / 1000;
    
        // Store the calculated price per common unit in harga_bahan
        $request->merge([
            'harga_bahan' => $pricePerUnit,
        ]);
    
        // Find the ingredient by ID
        $ingredient = Ingredient::findOrFail($id);
    
        // Update the ingredient
        $ingredient->update($request->all());
    
        return redirect()->route('ingredient.index')->with('success', 'Ingredient updated successfully.');
    }
    
    

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return redirect()->route('ingredient.index')->with('success', 'Ingredient deleted successfully.');
    }
}
