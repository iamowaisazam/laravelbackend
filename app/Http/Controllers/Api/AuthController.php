<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Gate;
use Auth;
use Con;
use Hash;
use Str;
use App\Profile;
use App\Token;
use App\Order;

class AuthController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('auth:api')->except(['login','file','register']);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function login(Request $request)
    {
        
        $token = Str::random(80);
        $user = User::where('email',$request->email)->get();

        if(count($user) > 0 ){
            $user = $user->first();
            if(Hash::check($request->password, $user->first()->password)){

                $ch = curl_init();
                curl_setopt($ch,CURLOPT_URL,"http://ip-api.com/json");
                curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                $data =  curl_exec($ch);
                $data = json_decode($data);


                $user->api_token = hash('sha256',$token);
                $user->save();
                
                 Token::create([
                    'user_id'=>$user->id,
                    'token' => $token,
                    'hash' => $user->api_token,
                    'status' =>'success' ,
                    'address' => serialize($data)
                ]);
                
                 $data = $user;
                 $data->username = $user->name;
                 $data->email = $user->email;
                 $data->role = $user->role->name;
                 $data->profile = $user->profile;
                 $data->photo = $user->profile->photo;
                 $data->orders = $user->orders;

                return response()->json([
                    "message" => 'Login Successfully',
                    "auth" => $data,
                    "token" => $token
                ],200);
            }
        }

        return response()->json([
            "message" => 'Email Or Password Not Found',
        ],500);
    }


        /**
     * Store a newly created resource in storage.
     */
    public function update(Request $request)
    {

        $user = $request->user();
        
        $user->profile->nick_name  =  $request->nick_name;
        $user->profile->profession = $request->profession;
        $user->profile->mobile = $request->mobile;
        $user->profile->birthday = $request->birthday;
        $user->profile->gender = $request->gender;
        $user->profile->bio = $request->bio;
        
        if(!empty($request->photo)){
          $user->profile->photo = $request->photo;     
        }
       
        $user->profile->save();  
     
        return response()->json([
            "message" => 'Update Successfully',
        ],200);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        
      $request->validate([
           'name' => 'required|string|max:255|unique:users',
           'email' =>'required|email|max:255|unique:users',
           'password' => 'required',          
      ]);
        
 
      $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 27,
            'status' => 'approved',
      ]);

       if ($user)
       {
            $profile= Profile::create([
            'user_id' => $user->id,
            'nick_name' => $user->name,
            'gender' => $user->gender,
            'mobile' => $user->mobile,
            'country' => $user->country,
            ]);
            
            return response()->json([
             "message" => 'User Created Successfully'],200);
       }

            
    }


    /**
     * Get Auth Details
     *
     */
    public function auth(Request $request)
    {
         $data = $request->user();
         $data->username = $request->user()->name;
         $data->email = $request->user()->email;
         $data->role = $request->user()->role->name;
         $data->photo = $data->profile->photo;
         $data->profile = $data->profile;
         $data->orders = $data->orders;
        
    
        return response()->json($data,200);
        
    }
    

    /**
     * Get Auth Details
     *
     */
    public function file(Request $request)
    {  
        if($request->hasFile('img')){ 
            $img = $request->file('img');
            $new_name = rand() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('admin/upload/'), $new_name);
            $path = asset('admin/upload/'.$new_name);

         }

        return response()->json(['file'=>$path],200);   
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        $user = $request->user();
        $user->api_token = null;
        $user->save();    

        return response()->json([
            "message" => 'Logout Success',
            ],200);
     }
     
       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {
    
       $user = $request->user();
       $order = Order::create([
               'user_id' => $user->id,
               'products' => serialize($request->cart),
               'address' => serialize($request->address),
               'payment' => $request->payment,
               'status' => $request->status,
               'total' => $request->total,
        ]);
      
      
        return response()->json([
            "message" => $request->all(),
            ],200);
     }
     
     
    
     
     


}