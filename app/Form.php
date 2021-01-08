<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Form extends Model
{
    
    protected $fillable = [
       'title','age','des','thumbnail','excerpt','gallery','price','attributes','user_id','quantity','status','pr_condition','token','ticket_token','ticket_s_location','ticket_e_location','ticket_type',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
       return $this->belongsTo('App\user','user_id');
    }


}