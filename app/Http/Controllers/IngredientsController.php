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
