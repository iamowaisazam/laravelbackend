<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Str;

class PasswordResetController extends Controller
{

    public function password_reset_request($email)
    {
        $user = User::where('email',$email)->first();
        if($user == null){
             return response()->json([
                "message" => 'Email Not Found',
             ],401);
        }

        $code =  rand(100000, 999999);
        PasswordReset::create([
            'email' => $user->email,
            'token' => $code,
            'user_id' => $user->id
        ]);

        $data = [
            'email' => $user->email,
            'name' => $user->name,
            'verification_code' => $code,
            'verify_button' => route('auth.password_reset_verify',$code),
        ];

        Mail::send('emails.passwordReset',$data,function ($mesage) use($data) {
            $mesage->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME')); 
            $mesage->to($data['email'],$data['name'])->subject('Password Reset');
        });

        return response()->json([
            "message" => 'Email Sent',
         ],200);  

    }



    public function password_reset_verify($code)
    {
        $token = PasswordReset::where('token',$code)->where('expired_at',null)->first();
        if($token == null){
             return response()->json([
                "message" => 'Invalid Token',
             ],401);
        }

        $user = User::find($token->user_id);
        if($user == null){
            return response()->json([
                "message" => 'Token Expired Please Generate Again',
            ],401);
        }

        return response()->json([
            "message" => 'Token Verified',
            "new_password_link" => $token->id
        ],200);

    }


    public function password_reset(Request $request,$id)
    {

        $validator = Validator::make($request->all(),[
            'password' => ['required','min:6','string','max:50','required_with:password_confirmation','same:password_confirmation'],
            'password_confirmation' => ['required','min:6','max:50'],
        ]);
        
        if($validator->fails()){
            return response()->json([
                "message" => "Validation Failed",
                "data" => ["validations" => $validator->messages()],
            ],403);
        }


        $token = PasswordReset::find($id);
        if($token == null){
             return response()->json([
                "message" => 'Token Expired Please Generate Again',
             ],401);
        }

        $user = User::find($token->user_id);
        if($user == null){
             return response()->json([
                "message" => 'Token Expired Please Generate Again',
             ],401);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        $token->expired_at = Carbon::now()->toDateTimeString();
        $token->save();

        return response()->json([
            "message" => 'Password Reset Successfully',
         ],200);  

    }

}