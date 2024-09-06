<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{  use HasFactory;
    
    /*
     * The table associated with the model.
     * @var string
     */
    protected $table = 'units';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    /*
     * Get the phone associated with the user.
     */
    public function products()
    {
        return $this->hasMany(Product::class,'unit_id');
    }

    
}
?>