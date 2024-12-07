<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
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


    public function newsletter_list(Request $request)
    { 
        $sort_by = $request->sort_by ?? 'desc';
        $order_by = $request->order_by ?? 'id';
        $limit = $request->limit ?? 10;
        $page = $request->page ?? 1;

        //Query
        $data = Newsletter::query();

        if($request->has('search') && $request->search != ''){
            $search = $request->search;
            $data->where('newsletters.name', 'like' , '%'.$search.'%')
            ->orWhere('newsletters.email','like' , '%'.$search.'%');
        }

        if($request->has('id') && $request->id){
            $data->where('newsletters.id',$request->id);
        }

        if($request->has('email') && $request->email){
            $data->where('newsletters.email',$request->email);
        }

        $total = $data->count(); 
        $data = $data->limit($limit)
        ->offset(($page - 1) * $limit)
        ->orderBy($order_by,$sort_by)
        ->select([
            'newsletters.id',
            'newsletters.name',
            'newsletters.email',
            'newsletters.created_at',
            'newsletters.updated_at'
        ])->get();

        $paginations = [];
        for ($i=1; $i < ceil($total / $limit); $i++) { 
          array_push($paginations,$i);    
        }

        return response()->json([
            'status' => 'success',
            "message" => "Get All Record Successfully",
            "data" =>  [
                'total' => $total,
                'from' => ($page - 1) * $limit + 1,
                'to' => min($page * $limit, $total),
                'page' => $page,
                'last_page' => ceil($total / $limit),
                'data' => $data,
                'links' => $paginations,
            ],
        ],200);

    }

    public function newsletter_add(Request $request )
    {
        $news = Newsletter::where('email',$request->email)->get();
        if(count($news) > 0){
            return response()->json([
                'status' => 'error',
                "message" => "Email Already Added",
            ],401);
        }

        $news = Newsletter::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => 'success',
            "message" => "Email Added Successfully",
        ],200);

    }

    public function newsletter_remove(Request $request )
    {
        $news = Newsletter::where('id',$request->id)->delete();
        return response()->json([
            'status' => 'success',
            "message" => "Record Deleted Successfully",
        ],200);
    }
    


}