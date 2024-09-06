<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class ProductReview extends Model
{ 
     use HasFactory;
    
    /*
     * The table associated with the model.
     */
    protected $table = 'product_reviews';
    protected $guarded = [];
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

}

?>