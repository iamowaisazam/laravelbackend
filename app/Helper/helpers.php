<?php

function hello()
    {
        return 'asdasd';


    }


   /**
     * CheckPermission
   */
if (! function_exists('CheckPermission')) {
    function CheckPermission($value)
    {

        $myPermission = Auth::user()->role->permission->pluck('name')->toArray();
        $result = in_array($value,$myPermission);    
       
        return $result;
    }
}

   /**
     * CheckOwn
   */
if (! function_exists('CheckOwn')) {

    function CheckOwn($value)
    {
        if(Auth::user()->id == $value ){
            return true;
        }else {
            return false;
        }

    }
}


   /**
     * CheckProfilePermission
   */

if (! function_exists('CheckProfilePermission')) {

    function CheckProfilePermission($profile)
    {
        $id = $profile->user->id;

        if(CheckAuthSuperAdmin()){
            return true;
        }

        if(GetRoleName($profile) == 'Super Admin'){
            return false;
        }

        if(CheckPermission('users.view_own_profile')){
           
            if(Auth::user()->id == $id){
             return true;
            }  
        
        }

        if(CheckPermission('users.view_others_profile')){
           
            if(Auth::user()->id != $id){
             return true;
            }  
        
        }

        return false;
    }
}

   /**
     * UpdateProfilePermission
   */

  if (! function_exists('UpdateProfilePermission')) {

    function UpdateProfilePermission($profile)
    {
        $id = $profile->user->id;

        if(CheckAuthSuperAdmin()){
            return true;
        }

        if(GetRoleName($profile) == 'Super Admin'){
            return false;
        }


        if(CheckPermission('users.update_others_profile')){
           
            return true;
        }

        return false;
    }
}



   /**
     * CheckAuthSuperAdmin
   */
if (! function_exists('CheckAuthSuperAdmin')) {

    function CheckAuthSuperAdmin()
    {
        if(Auth::user()->role->name == 'Super Admin'){
            return true;
        }else {
            return false;
        }

    }
}

   /**
     * CheckSuperAdminWithId
   */
if (! function_exists('CheckSuperAdminWithId')) {

    function CheckSuperAdminWithId($user)
    {
        if($user->role->name == 'Super Admin'){
            
            return true;
        
        }else{

            return false;
        }
    }
}


   /**
     * GetRoleName
   */
  if (! function_exists('GetRoleName')) {

    function GetRoleName($user)
    {  
          return $user->user->role->name;   
    }
}









?>