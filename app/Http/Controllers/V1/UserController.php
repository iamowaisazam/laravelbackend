<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

     /*
     * Get Auth Details
     */
    public function auth(Request $request)
    {
        try {

            $data = $request->user();
            return response()->json([
                "message"=> "Get Profile Successfully",
                "user"=> $data,
                ],200);  
            
        } catch (\Exception $e) {
            return response()->json(["message" => "Error Found"],500);
        }
    }
    
   
    
    public function auth_update(Request $request){
        
         $user = $request->user();
        
         //  $validator = Validator::make($request->all(),[
        //     'name' =>'required|min:6|max:255|unique:users,name,'.$user->id, 
        //     'email' =>'required|email|unique:users,email,'.$user->id, 
        //  ]);
        
        //  if($validator->fails()){
        //     return response()->json(["validations"=>$validator->messages()],403);
        //  }
         
        //  $user->name = $request->name;
        //  $user->email = $request->email;
        //  $user->save();
         
        //  if($request->has('password')){
             
        //     $validator = Validator::make($request->all(),[
        //       'password' =>'required|min:6|max:255', 
        //     ]);
             
        //     if($validator->fails()){
        //        return response()->json($validator->messages(),403);
        //     }
             
        //     $user->password = Hash::make($request->password);
        //     $user->save();
        //  }
         
        //   if($request->has('thumbnail')){
        //         $path = '/images/profiles';
        //         $fileName = $user->id.'.'.$request->file('thumbnail')->extension(); 
        //         $request->file('thumbnail')->move(public_path($path), $fileName);
        //         $user->thumbnail = url('/public/images/profiles/'.$fileName);
        //         $user->save();
        //  }
         
        return response()->json([
            "message"=> "Update User Successfully",
            "user"=> $user,
        ],200);
        
    }
    



     /*
     * Get Auth Details
     */
    public function logout(Request $request)
    {
        try {

            $request->user()->currentAccessToken()->delete();
            return response()->json([
                "message"=> "Logout User Successfully",
                ],200);

        } catch (\Exception $e) {
            return response()->json(["message" => "Error Found"],500);
        }
        
    }
   

}