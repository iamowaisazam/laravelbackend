<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Order extends Model
{ use HasFactory;
    
    /*
     * The table associated with the model.
     */
    protected $table = 'orders';
    
    protected $guarded = [];
    
    protected $dates = [
        'created_at',
        'updated_at',
        'date'
    ];
    
    
      /**
     * Get the phone associated with the user.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
     public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }
    
}

?>