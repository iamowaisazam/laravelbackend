<?php

namespace App\Http\Controllers\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserEmailVerification;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

   /*
    * Show the profile for a given user.
    */
    // public function google_redirect(Request $request)
    // {
    //     return Socialite::driver('github')->redirect();
    // }


   /*
    * Show the profile for a given user.
    */
    // public function facebook_redirect(Request $request)
    // {
    //     return Socialite::driver('facebook')->stateless()->redirect();
    // }

   /*
    * Show the profile for a given user.
    */
    // public function github_redirect()
    // {
    //     return Socialite::driver('github')->stateless()->redirect();
    // }

    


    /*
    * Show the profile for a given user.
    */
    // public function google_callback(Request $request)
    // {
    //     dd($request->all());
    // }


   /*
    * Show the profile for a given user.
    */
    // public function facebook_callback(Request $request)
    // {

    //     dd($request->all());
    // }



   /*
    * Show the profile for a given user.
    */
    // public function github_callback($token)
    // {

        

    // }

    
    /*
    * Show the profile for a given user.
    */
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(),
        [
            'email' => [
                'required',
                'string',
                'email',
                'min:3',
                'max:50'
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'max:50',
            ],
        ]);
        
        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => "Validation Failed",
                "errors" =>  $validator->messages(),
            ],403);
        }


        $user = User::where('email',$request->email)->first();
        if($user == false){
            return response()->json([
                "status" => "error",
                "message" => 'Authentication Failed',
            ],403);
        }

        if(Hash::check($request->password, $user->password) == false){
            return response()->json([
                "status" => "error",
                "message" => 'Authentication Failed',
            ],403);
        }

        // if($user->email_verified != 1){
        //     return response()->json([
        //         "message" => 'Please Verify Your Email',
        //     ],403);
        // }
 
        $token = $user->createToken('tokens')->plainTextToken;
        return response()->json([
                "message" => 'Login Successfully',
                "data" => [
                    'user' => $user,
                    'token' => $token
                ]
        ],200);  

    }


    public function resend_email_verification($email)
    {
        $user = User::where('email',$email)->first();
        if($user == null){
             return response()->json([
                "message" => 'Email Not Found',
             ],401);
        }

        if($user->email_verified == 1){
            return response()->json([
               "message" => 'Email Already Verified',
            ],401);
        }

        $code =  rand(100000, 999999);
        $emailVerification = UserEmailVerification::create([
            'email' => $user->email,
            'token' => $code,
            'user_id' => $user->id
        ]);

        $data = [
            'email' => $user->email,
            'name' => $user->name,
            'verification_code' => $code,
            'verify_button' => route('auth.verify_email',['email' => $user->email,'token' => $code]),
        ];

        Mail::send('emails.emailVerification',$data,function ($mesage) use($data) {
            $mesage->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME')); 
            $mesage->to($data['email'],$data['name'])->subject('Email Verification');
        });

        return response()->json([
            "message" => 'Email Sent',
         ],200);  

    }

    public function social_login (Request $request)
    {

        // if($request->has('provider') == false && $request->has('token') == false){
        //     return response()->json(['message' => 'Provider & Token Required'],422);
        // }

        // if(!in_array($request->provider,['facebook','google','github'])){
        //   return response()->json(['message' => 'Provider Not Found'],422);
        // }


        // try {
        //     $provider = Socialite::driver($request->provider)->userFromToken($request->token);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Invalid credentials provided.'], 422);
        // }

        // $id = $provider->id;
        // $email = $provider->email;
        // $username = $provider->nickname;
        // $title = $provider->name;
        // $avatar =  $provider->avatar;
        // $token = $provider->token;
        // $refreshToken = $provider->refreshToken;

        // $user = User::where('github_id',$id)->first();    
        // if($user == null){

        //         if(count(User::where('email',$email)->get()) > 0){
        //             return response()->json(['message' => 'Email Already Exist.'], 422);   
        //         }

        //         $user = User::create([
        //             'name' => $username,
        //             'email' => $email,
        //             'title' => $title,
        //             'image' => $avatar,
        //             'github_id' => $id,
        //             'email_verified' => Carbon::now()->toDateTimeString(),
        //         ]);

        // }
        
        // $token = $user->createToken('auth_token')->plainTextToken;
        // return response()->json([
        //         "message" => 'Login Successfully',
        //         "data" => [
        //             'token' => $token
        //         ]
        // ],200); 

    }




    public function verify_email($email,$token)
    {

        $user = User::where('email',$email)->first();
        if($user == null){
             return response()->json([
                "message" => 'Email Not Found',
             ],401);
        }

        if($user->email_verified == 1){
            return response()->json([
               "message" => 'Email Already Verified',
            ],401);
        }

        if($user->verification_email && $user->verification_email->token != $token){
            return response()->json([
                "message" => 'Verification Failed',
            ],401);
        }

        $user->verification_email->verified_at = Carbon::now()->toDateTimeString();
        $user->verification_email->save();
        $user->email_verified = 1;
        $user->save();

        return response()->json([
            "message" => 'Email Successfully Verified',
            "data"=> [
                "user_id" => $user->id,
            ]
        ],200);
    }

    /**
     * Show the profile for a given user.
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'fullname' => ['required','string','min:2','max:30'],
            'email' => ['required','string','email','unique:users,email','max:100'],
            'phone' => ['nullable','string','max:50'],
            'password' => ['required','min:6','string','max:50'],
            // 'password_confirmation' => ['required','min:6','max:50'],
            // 'image' => ['nullable','mimes:jpeg,png,jpg','max:2048'],
            // 'terms' => ['integer'],
            // 'notification' => ['integer'],
        ]);
        
        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => "Validation Failed",
                "errors" => $validator->messages(),
            ],403);
        }

        // dd($request->all());

        $user = User::create([
            'name' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'phone' => $request->has('phone') ? $request->phone : null,
        ]);

        $token = $user->createToken('tokens')->plainTextToken;

        // dd($token);

        // $code =  rand(100000, 999999);
        // UserEmailVerification::create([
        //     'email' => $user->email,
        //     'token' => $code,
        //     'user_id' => $user->id
        // ]);

        // $data = [
        //     'email' => $user->email,
        //     'name' => $user->name,
        //     'verification_code' => $code,
        //     'verify_button' => route('auth.verify_email',['email' => $user->email,'token' => $code]),
        // ];

        // Mail::send('emails.emailVerification',$data,function ($mesage) use($data) {
        //     $mesage->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME')); 
        //     $mesage->to($data['email'],$data['name'])->subject('Email Verification');
        // });

        return response()->json([
         "status" => "success",
         "message" => 'User Created Successfully Please Check Your Email',
         "data" => [
              'token' => $token,   
           ]  
        ],200);

    }


    


  



    
    

}