<?php
namespace App\Utils;

use App\User;
use App\Setting;
use App\PostType;
use App\University;
use App\Course;
use App\Enquiry;
use App\News;
use App\Event;
use App\Testimonal;
use App\Role;
use App\FileManager;
use App\Category;
use App\Product;
use App\Form;

class Config {

    
   public function files(){
    
    return FileManager::all();

  }
  
  public function settings(){
    
    $setting = Setting::all();
    $setting = $setting->pluck('value','name');
    $setting= $setting->toArray();
    $setting = (object)$setting;
    return $setting;
    
  }
  
  


   public function getUsersByRoleName($name){
    $Enquiry = Role::where('name',$name)->get();
    return $Enquiry->first()->users; 
  }


  public function getUsersWhereNotIn($name){

      $roles = Role::whereNotIn('name',$name)->pluck('id')->toArray();
      $roles = User::whereIn('role_id',$roles)->get();

    return $roles;
  }




 public function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}




}

?>

