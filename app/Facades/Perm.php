<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Perm extends Facade{
  
   public static function getFacadeAccessor(){
        return "Perm";
       }

}

?>