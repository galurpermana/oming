<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['name', 'stock', 'harga_bahan', 'unit'];

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'food_ingredients', 'ingredient_id', 'food_id')
                    ->withPivot('quantity');
    }
}
