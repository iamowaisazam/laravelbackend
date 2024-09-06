<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Model
{  use HasFactory;
    
    /*
     * The table associated with the model.
     */
    protected $table = 'purchase_orders';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'date'
    ];
    
    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }
    
     public function items()
    {
        return $this->hasMany('App\Models\PurchaseOrderItem','parent_id');
    }
    
}
?>