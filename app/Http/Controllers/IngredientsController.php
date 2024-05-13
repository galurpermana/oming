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
    
        // Calculate the price per common unit
        $price = $request->harga_bahan;
        $unit = $request->priceunit;
    
        switch ($unit) {
            case 'Kilogram':
                // Convert price to per kilogram if unit is Gram
                $pricePerUnit = $price / 1000; // 1 kilogram = 1000 grams
                break;
            case 'Liter':
                // Convert price to per liter if unit is Liter
                // Add conversion logic as needed for other units
                break;
            // Add cases for other units as needed
        }
    
        // Store the calculated price per common unit in harga_bahan
        $request->merge([
            'harga_bahan' => $pricePerUnit,
            'priceunit' => $unit
        ]);
        // dd($request);
    
        Ingredient::create($request->all());
    
        return redirect()->route('ingredient.index')->with('success', 'Ingredient created successfully.');
    }
    
    

    public function edit(Ingredient $ingredient)
    {
        return view('ingredient.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name,' . $ingredient->id,
            'stock' => 'required|numeric',
            'harga_bahan' => 'required|numeric',
            'unit' => 'required|string|max:255',
        ]);

        $ingredient->update($request->all());

        return redirect()->route('ingredient.index')->with('success', 'Ingredient updated successfully.');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();

        return redirect()->route('ingredient.index')->with('success', 'Ingredient deleted successfully.');
    }
}
