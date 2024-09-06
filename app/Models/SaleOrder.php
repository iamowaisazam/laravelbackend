<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleOrder extends Model
{  use HasFactory;
    
    /*
     * The table associated with the model.
     */
    protected $table = 'sale_orders';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'date'
    ];
    
    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
    
     public function items()
    {
        return $this->hasMany('App\Models\SaleOrderItem','parent_id');
    }
    
}
?>