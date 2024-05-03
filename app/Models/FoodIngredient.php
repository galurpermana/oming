<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodIngredient extends Model
{
    protected $fillable = ['food_id', 'ingredient_id', 'quantity','unit'];
}
