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
        'title_es',
        'title_pt',

        'link',
        'link_es',
        'link_pt',

        'short_description',
        'short_description_es',
        'short_description_pt',

        'thumbnail',
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