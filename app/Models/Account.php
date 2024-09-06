<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class Account extends Model
{ 
    
     use HasFactory;
     
    /*
     * The table associated with the model.
     */
    protected $table = 'accounts';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
     public function pparent()
    {
        return $this->belongsTo(AccountCategory::class,'parent_id');
    }


    // public function transactions()
    // {
        
    //     return $this->hasMany(Transaction::class,'');
    // }
    
}

?>