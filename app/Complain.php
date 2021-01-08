<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;


class Complain extends Model
{
    //
    protected $fillable = [
       'message','user_id','is_admin','status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
  protected $dates = [
        'created_at',
        'updated_at',
    ];
  
}