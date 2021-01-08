<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    
    protected $fillable = [
       'old','slug','title','des','thumbnail','excerpt','gallery','parent','price','attributes','category_id','user_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];



    public function category()
    {
       return $this->belongsTo('App\Category','category_id');
    }
}