<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Vendor extends Model
{  use HasFactory;
    
    
    /*
     * The table associated with the model.
     */
    protected $table = 'vendors';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    public function purchase()
    {
        return $this->hasMany(PurchaseOrder::class,'vendor_id');
    }
    
    
    /*
     * Get the phone associated with the user.
     */
    public function products()
    {
        return $this->hasMany(Product::class,'vendor_id');
    }
    
}

?>