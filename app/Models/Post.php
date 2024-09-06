<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Post extends Model
{ 
     use HasFactory;
    
    /*
     * The table associated with the model.
     */
    protected $table = 'posts';
    protected $guarded = [];
    protected $appends = array('imagelink','gallerylinks');
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public function getImageLinkAttribute()
    {
        return uploaded_files($this->thumbnail);
    }

    public function getGallerylinksAttribute()
    {   
         $images = [];
         $im = explode(',',$this->images);
         foreach ($im as $value) {
            array_push($images,uploaded_files($value));
         }
         return implode(',',$images);
    }

     public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    
    public function purchase()
    {
        return $this->hasMany(PurchaseOrderItem::class,'product_id');
    }
    
    public function sale()
    {
        return $this->hasMany(SaleOrderItem::class,'product_id');
    }

}

?>