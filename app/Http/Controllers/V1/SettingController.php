<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingController extends Controller
{

    public function index(Request $request)
    {
        
       $lang = $request->lang ?? 'en';
       $value = 'value_'.$lang;

       $module = Setting::select([
        'id',
        'name',
        'value_'.$lang.' as value',
       ])->pluck('value','name')->toArray();

        return response()->json([
            "message" => "Record Created Successfully",
            "data" => $module,
        ],200);

    }

    
    /*
     * Show the profile for a given user.
     */
    public function store(Request $request)
    {

        // dd($request->all());

        // return response()->json([
        //     "data" => $request->all(),
        //     "message" => "Record Updated Successfully",
        // ],200);

        $name = $request->name;
        $lang = $request->lang;

        $setting = Setting::where('name',$name)->first();
        if($setting){
            Setting::where('name',$name)->update([
                'value_'.$lang => json_encode($request->all()),
            ]);
        }else{
            Setting::create([
                'name' => $name,
                'value_'.$lang => json_encode($request->all()),
            ]);
        }

        return response()->json([
            "message" => "Record Updated Successfully",
        ],200);

    }



     /*
     * Show the profile for a given user.
     */
    public function show($id,Request $request )
    {

        $lang = $request->lang ?? 'en';
        $value = 'value_'.$lang;
        $module = Setting::where('name',$id)->pluck($value,'name')->toArray();

        if($module){
            return response()->json([
                "message" => "Record Created Successfully",
                "data" => $module,
            ],200);
        }else{
            return response()->json([
                "message" => "Record Not Found",
            ],401);
        }

    }
    


}