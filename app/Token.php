<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Token extends Model
{
    
  protected $fillable = ['hash','user_id','token','status','address','created_at','updated_at'];

  
  protected $dates = ['created_at','updated_at'];
 
}