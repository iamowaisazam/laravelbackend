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
        'title_en',
        'title_es',
        'title_pt',

        'link_en',
        'link_es',
        'link_pt',

        'short_description_en',
        'short_description_es',
        'short_description_pt',

        'thumbnail_en',
        'thumbnail_es',
        'thumbnail_pt',

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