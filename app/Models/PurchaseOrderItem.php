<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class PurchaseOrderItem extends Model
{
    
    /*
     * The table associated with the model.
     * @var string
     */
    protected $table = 'purchase_order_items';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
 
      public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
    
     public function pparent()
    {
        return $this->belongsTo('App\Models\PurchaseOrder','parent_id');
    }
    
}
?>