<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;

class Permission extends Model
{
    //

    protected $fillable = [
        'name', 'detail','created_at','updated_at' 
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public function role()
    {
        return $this->belongsToMany(Role::class,'role__permissions','role_id','permission_id');
    }
}
