<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class News extends Model
{
    
  protected $fillable = ['title','details','excerpt','status','slug','thumbnail','created_at','updated_at'];

  
  protected $dates = ['created_at','updated_at'];
 
}