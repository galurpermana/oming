<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;
    

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'date',
        'image_path',
        'status'
        
    ];

    public function user() {
        return $this->belongsTo(User::class); 
    }

    public function food() {
        return $this->belongsToMany(Food::class, 'food_order', 'order_id', 'food_id')->withPivot('quantity'); 
    }
}
