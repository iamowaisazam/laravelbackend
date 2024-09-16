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
       $module = Setting::select([
        'id',
        'name',
        'value_'.$lang.' as value',
       ])->get();


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
        $lang = $request->lang;

        foreach ($request->data as $key => $value) {
            // dd($value);
            Setting::where('name',$key)->update([
                'value_'.$lang => $value,
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

        $module = Setting::where('name',$id)->first();
        if(count($module) > 0){
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