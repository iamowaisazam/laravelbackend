<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Setting extends Model
{  use HasFactory;
    
    /*
     * The table associated with the model.
     * @var string
     */
    protected $table = 'settings';    


      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'value_en',
        'value_es',
        'value_pt',
        'type',
        'created_at',
        'updated_at',
    ];


    protected $dates = [
        'created_at',
        'updated_at',
    ];

}
?>