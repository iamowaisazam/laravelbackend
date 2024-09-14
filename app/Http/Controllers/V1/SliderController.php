<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    
    /**
     * Show the profile for a given user.
     */
    public function index(Request $request)
    { 
        

        $limit = 10;
        $sort_by = 'asc';
     
        $data = Slider::query();

        if($request->has('search')){
            $search = $request->search;
            $data->where('title', 'like', '%'.$search.'%');
        }

        if($request->has('sort_by') && $request->sort_by != ''){
            $sort_by = $request->sort_by;
        }

        if($request->has('limit') && is_numeric($request->limit)){
            $limit = $request->limit;
        }

        if($request->has('order_by') && $request->order_by != null){
            $data->orderBy($request->order_by,$sort_by);
        }

        // $data->select([
        //     "id",
        //     "title",
        //     "link",
        //     "short_description",
        //     "thumbnail",
        //     "lang",
        //     "sorting",
        //     "status",
        //     "created_by",
        //     "created_at"
        // ]);

        $data = $data->paginate($limit);

        return response()->json([
            'status' => 'success',
            "message" => "Get All Record Successfully",
            "data" =>  $data,
        ],200);

    }

    /*
     * Show the profile for a given user.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'title' => ['required','max:300'],
            'title_es' => ['nullable','max:300'],
            'title_pt' => ['nullable','max:300'],

            'link' => ['nullable','max:300'],
            'link_es' => ['nullable','max:300'],
            'link_pt' => ['nullable','max:300'],

            'short_description' => ['nullable','max:300'],
            'short_description_es' => ['nullable','max:300'],
            'short_description_pt' => ['nullable','max:300'],

            'thumbnail' => ['nullable','max:300'],
            'thumbnail_es' => ['nullable','max:300'],
            'thumbnail_pt' => ['nullable','max:300'],

            'sorting' => ['nullable','integer','max:300'],
            'status' => ['required','integer','max:300'],
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => "Validation Failed",
                "errors" =>  $validator->messages(),
            ],403);
        }

       $module = Slider::create([
            'title' => $request->title,
            'title_es' => $request->title_es,
            'title_pt' => $request->title_pt,

            'link' =>  $request->link,
            'link_es' =>  $request->link_es,
            'link_pt' =>  $request->link_pt,

            'short_description' =>  $request->short_description,
            'short_description_es' =>  $request->short_description_es,
            'short_description_pt' =>  $request->short_description_pt,

            'thumbnail' =>  $request->thumbnail,
            'thumbnail_es' =>  $request->thumbnail_es,
            'thumbnail_pt' =>  $request->thumbnail_pt,

            'sorting' =>  $request->sorting,
            'status' =>  $request->status,
        ]);

        return response()->json([
            "message" => "Record Created Successfully",
            "data" => ['id' => $module->id]
        ],200);


    }



     /*
     * Show the profile for a given user.
     */
    public function show($id,Request $request )
    {
        $slider = Slider::where('id',$id)->get();       
        return response()->json([
            "message" => 'Get Record Successfully',
            "data" => $slider,
        ],200);
    }
    


    /*
     * Show the profile for a given user.
     */
    public function update(Request $request,$id)
    {

        $module = Slider::where('id',$id)->first();
        if(!$module){
            return response()->json([
                "status" => "error",
                "message" => "Record Not Found"
            ],403);
        }

        $validator = Validator::make($request->all(),
        [
            'title' => ['required','max:300'],
            'title_es' => ['nullable','max:300'],
            'title_pt' => ['nullable','max:300'],

            'link' => ['nullable','max:300'],
            'link_es' => ['nullable','max:300'],
            'link_pt' => ['nullable','max:300'],

            'short_description' => ['nullable','max:300'],
            'short_description_es' => ['nullable','max:300'],
            'short_description_pt' => ['nullable','max:300'],

            'thumbnail' => ['nullable','max:300'],
            'thumbnail_es' => ['nullable','max:300'],
            'thumbnail_pt' => ['nullable','max:300'],

            'sorting' => ['nullable','integer','max:300'],
            'status' => ['required','integer','max:300'],
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => "Validation Failed",
                "errors" =>  $validator->messages(),
            ],403);
        }

        $module->title = $request->title;
        $module->title_es = $request->title;
        $module->title_pt = $request->title;

        $module->link =  $request->link;
        $module->link_es =  $request->link_es;
        $module->link_pt =  $request->link_pt;

        $module->short_description =  $request->short_description;
        $module->short_description_es =  $request->short_description_es;
        $module->short_description_pt =  $request->short_description_pt;

        $module->thumbnail =  $request->thumbnail;
        $module->thumbnail_es =  $request->thumbnail_es;
        $module->thumbnail_pt =  $request->thumbnail_pt;

        $module->sorting =  $request->sorting;
        $module->status =  $request->status;
        $module->save();
        

        return response()->json([
            "message" => "Record Updated Successfully",
            "data" => ['id' => $module->id]
        ],200);

       
    }



    /*
     * Show the profile for a given user.
     */
    public function destroy($id)
    {
        $module = Slider::find($id);
        if($module == null){
             return response()->json([
                "status","error",
                "message" => 'Record Not Found']
                ,403);
        }
        
        $module->delete();
        return response()->json([
            "message" => 'Record Deleted Successfully',
            "data" => ['id' => $id]
        ],200);
    }



}