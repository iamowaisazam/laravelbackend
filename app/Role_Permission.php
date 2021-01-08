<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_Permission extends Model
{
    //

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'permission_id','created_at','updated_at' 
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
