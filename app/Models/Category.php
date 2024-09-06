<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;

class Category extends Model
{  use HasFactory;
    
    /*
     * The table associated with the model.
     * @var string
     */
    protected $table = 'categories';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    
    public function product_count(){
        
        $count = 0;    
        if($this->parent_id == 0){
              
              $idz = [];
              foreach(Category::where('parent_id',$this->id)->get() as $child){
                        $products = Product::where('category_id',$child->id)->get();    
                        foreach($products as $product){
                         array_push($idz,$product->id);    
                        }
              }
              $count = $idz;
              
        }else{
            $product = Product::where('category_id',$this->id)->pluck('id')->toArray();
            $count = $product;
        }
        
        
        return $count;
    }


    /*
     * Get the phone associated with the user.
     */
    public function children()
    {
        return $this->hasMany(Category::class,'parent_id');
    }
 
    
}
?>