<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Customer extends Model
{  use HasFactory;
    
    /*
     * The table associated with the model.
     * @var string
     */
    protected $table = 'customers';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    
     public function sale()
    {
        return $this->hasMany(SaleOrder::class,'customer_id');
    }
    
}

?>