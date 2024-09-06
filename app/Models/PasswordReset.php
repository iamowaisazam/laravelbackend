<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class PasswordReset extends Model
{ 
    
    /*
     * The table associated with the model.
     */
    protected $table = 'password_resets';
    protected $guarded = [];

    public $timestamps = false;
    
    protected $dates = [
        'created_at',
        'expired_at'
    ];
    
    
    
}
?>