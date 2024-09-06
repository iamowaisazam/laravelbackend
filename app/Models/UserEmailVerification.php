<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class UserEmailVerification extends Model
{ 

    public $timestamps = false;

    
    /*
     * The table associated with the model.
     */
    protected $table = 'user_email_verifications';
    // protected $guarded = [];

    protected $fillable = [
        'email',
        'user_id',
        'token',
    ];
    
    protected $dates = [
        'created_at',
        'verified_at',
    ];
    
     public function user()
    {
        return $this->hasOne(User::class,'user_id')->orderBy('created_at', 'desc');
    }
    
}
?>