<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model
{
    //
    protected $fillable = [
       'slug','title','des','thumbnail','excerpt','gallery','parent',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function products()
    {
       return $this->hasMany(Product::class);
    }

    

}