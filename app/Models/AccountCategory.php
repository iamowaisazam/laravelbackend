<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountCategory extends Model
{  use HasFactory;
    
    /*
     * The table associated with the model.
     * @var string
     */
    protected $table = 'account_categories';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
      /*
     * Get the phone associated with the user.
     */
    public function parent_account()
    {
        return $this->belongsTo(AccountCategory::class,'parent_id');
    }


    /*
     * Get the phone associated with the user.
     */
    public function sub_accounts()
    {
        return $this->hasMany(AccountCategory::class,'parent_id');
    }
 
    
}

?>