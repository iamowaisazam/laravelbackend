<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class ProductTag extends Model
{ 
     use HasFactory;
    /*
     * The table associated with the model.
     */
    protected $table = 'product_tags';
    protected $guarded = [];
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
}

?>