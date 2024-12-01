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
  
    
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = []; 

}

?>