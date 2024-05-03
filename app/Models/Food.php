<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'foods';

    // /**
	//  * The database table used by the model.
	//  *
	//  * @var string
	//  */
	// protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'description', 'price', 'picture'];

    public function orders() {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'food_ingredients', 'food_id', 'ingredient_id')
                    ->withPivot('quantity');
    }
}
