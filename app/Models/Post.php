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
    protected $fillable = [
        'id',
        'slug',
        'category_id',
        
        'title_en',
        'title_es',
        'title_pt',
        'short_description_en',
        'short_description_es',
        'short_description_pt',
        'long_description_en',
        'long_description_es',
        'long_description_pt',
        'thumbnail_en',
        'thumbnail_es',
        'thumbnail_pt',

        'type',
        'is_featured',
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