<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Profile extends Model
{
    //

            /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     "fname","lname","birthday","other","user_id","nick_name","mobile","bio","gender","male","profession","story","country","state","city","zip","street_address","street_address2","photo","created_at","updated_at" 
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    protected $casts = [
        'social' => 'array',
        'others' => 'array',
    ];

    public function user()
    {
       return $this->belongsTo('App\user','user_id');
    }
    
}
