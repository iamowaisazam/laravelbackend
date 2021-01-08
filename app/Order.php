<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    
  protected $fillable = ['user_id','status','products','address','total','payment','created_at','updated_at'];
  protected $dates = ['created_at','updated_at'];
 
     public function getAddressAttribute($value)
    {
        return unserialize($value);
    }
    
     public function getProductsAttribute($value)
    {
        
        return unserialize($value); 
    }

}