<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Transaction extends Model
{ 
    
     use HasFactory;
     
    /*
     * The table associated with the model.
     */
    protected $table = 'transactions';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
     public function sender()
    {
        return $this->belongsTo(Account::class,'account_id');
    }
    
     public function receiver()
    {
        return $this->belongsTo(Account::class,'received_at');
    }
    
}

?>