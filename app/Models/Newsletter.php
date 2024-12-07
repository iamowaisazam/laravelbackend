<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Newsletter extends Model
{ 
     use HasFactory;
    
    /*
     * The table associated with the model.
     */
    protected $table = 'newsletters';
  
    
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = []; 

}

?>