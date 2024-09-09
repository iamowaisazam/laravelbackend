<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Slider extends Model
{  use HasFactory;
    
    /*
     * The table associated with the model.
     * @var string
     */
    protected $table = 'sliders';    


      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'title',
        'link',
        'short_description',
        'thumbnail',
        'lang',
        'sorting',
        'status',
        'created_by',
        'created_at',
        'updated_at',
    ];


    protected $dates = [
        'created_at',
        'updated_at',
    ];

   
    
}
?>