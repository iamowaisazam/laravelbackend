<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class FileManager extends Model
{
    
  protected $table = 'filemanagers';
  protected $fillable = ['title','extension','name','created_at','updated_at','user_id','size','url'];
  
  protected $dates = ['created_at','updated_at'];
}