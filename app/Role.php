<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permission;

class Role extends Model
{
    //

       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'detail','created_at','updated_at' 
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class,'role__permissions','role_id','permission_id');
    }
}
