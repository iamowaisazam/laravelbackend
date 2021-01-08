<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
         $p = Permission::all();   
         foreach ($p as $permission) {
        
         Gate::define($permission->name,function($user,$model) use ($permission){
         if($user->role->name != 'super-admin'){

                $p = $user->role->permission->pluck('id')->toArray();
                if(in_array($permission->id,$p)){
                                
                                      if($model != 'none'){
                                                if($model == $user->id){
                                                        return true;
                                                    }else{
                                                        return false;
                                                    }
                                        }else{
                                        
                                            return true;
                                        }
                                
                    }else{
                        return false;
                    }
                 
             }
             return true;
             
         });
       }
    }
}
