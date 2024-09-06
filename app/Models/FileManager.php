<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class FileManager extends Model
{  use HasFactory;
    
    /*
     * The table associated with the model.
     * @var string
     */
    protected $table = 'file_managers';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
}

?>