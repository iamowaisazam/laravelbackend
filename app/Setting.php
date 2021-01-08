<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name","type","value","created_at","updated_at" 
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
}
