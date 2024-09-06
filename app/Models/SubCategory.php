<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class SubCategory extends Model
{  use HasFactory;
    
    /*
     * The table associated with the model.
     * @var string
     */
    protected $table = 'subcategories';    
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /*
     * Get the phone associated with the user.
     */
    public function category()
    {
        return $this->belongsTo('\App\Models\Category','category_id');
    }
    
}
?>