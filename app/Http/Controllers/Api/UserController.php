<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Gate;
use Auth;
use Con;
use Hash;
use App\Profile;
use Str;

class UserController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('auth:api')->except(['all','create','update','delete','get']);
    }


    /**
     * getAllUsers
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        
         $data = [];
         $users = User::all();
         
         foreach ($users as $key => $value) {
        
          $current = [];
          $current['key'] = $key;
          $current['id'] = $value->id;
          $current['name'] = $value->name;
          $current['email'] = $value->email;
          $current['role'] = $value->role;
          $current['profile'] = $value->profile;
          $current['date'] = $value->created_at;
          $current['status'] = $value->status;
          
          array_push($data,$current);
          
        }

        return response()->json([
            "message" => 'Get Users Successfully',
            "users" => $data
        ],200);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    $token = Str::random(80);
      $request->validate([
           'name' => 'required|string|max:255|unique:users',
           'email' =>'required|email|max:255|unique:users',
           'password' => 'required',          
      ]);
        
      $user= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 27,
            'status' => 'approved',
            'api_token' => hash('sha256',$token),
      ]);
            
      $profile= Profile::create([
                'user_id' => $user->id,
                'nick_name' => $user->name
      ]);
      
      return response()->json([
            "message" => 'User Created Successfully',
            "user" => $profile
           ],200);
    }


    /**
      * Display the specified resource.
      *
      * @param  \App\Profile  $profile
      * @return \Illuminate\Http\Response
    */
    public function get($id)
    {

        $user = User::find($id);
        return response()->json([
            "message" => 'User Get Successfully',
            "user" => $user,
            "profile" => $user->profile,
           ],200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
       
        $user = User::find($id);
        if(! $user){
            return response()->json(["message" => 'Invalid User'],500);
        }

        $request->validate([
            'name' => 'required|min:3|unique:users,name,'.$user->id,
            'email' =>'required|email|max:255|unique:users,email,'.$user->id,
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        if($request->password != null){
          $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json([
            "message" => 'User Update Successfully',
            "user" => $user
           ],200);
    }

  
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

           $profile= Profile::where('user_id',$id)->first();
            
           DB::beginTransaction();
          try {
                Profile::destroy($profile->id);  
                User::destroy($id);
                DB::commit();          
                return response()->json(["message" => "Deleted Successfully"],200);        
        } catch (\Exception $e) {
            // Rollback Transaction
                DB::rollback();
                return response()->json(["message" => "Cannot Delete"],500);    
        }
        
    }
    
    
}