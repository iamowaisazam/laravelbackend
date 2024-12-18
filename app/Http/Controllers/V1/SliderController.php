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
        
        $lang = $request->lang ?? 'en';
        $sort_by = 'asc';
        $limit = 10;

     
        $data = Slider::query();

        if($request->has('search')){
            $search = $request->search;
            $data->where('title', 'like', '%'.$search.'%');
        }

        if($request->has('sort_by') && $request->sort_by != ''){
            $sort_by = $request->sort_by;
        }

        if($request->has('order_by') && $request->order_by != null){
            $data->orderBy($request->order_by,$sort_by);
        }

        $total = $data->count();
       
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $data = $data->limit($limit)->offset($offset)
        ->select([
            'id',
            'title_'.$lang.' as title',
            'link_'.$lang.' as link',
            'short_description_'.$lang.' as short_description',
            'thumbnail_'.$lang.' as thumbnail',
        ])->get();

        $data = $data->map(function ($item){
            $item['thumbnail_prev'] = asset($item['thumbnail']);
            return $item;
        });

        return response()->json([
            'status' => 'success',
            "message" => "Get All Record Successfully",
            "data" =>  [
                'page' => $currentPage,
                'total' => $total,
                'data' => $data, 
            ],
        ],200);

    }

    /*
     * Show the profile for a given user.
     */
    public function store(Request $request)
    {
        $lang = $request->lang ?? 'en';

        $validator = Validator::make($request->all(),
        [
            'title' => ['nullable','max:300'],
            'link' => ['nullable','max:300'],
            'short_description' => ['nullable','max:300'],
            'thumbnail' => ['nullable','max:300'],
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
            'title_'.$lang => $request->title,
            'link_'.$lang =>  $request->link,
            'short_description_'.$lang =>  $request->short_description,
            'thumbnail_'.$lang =>  $request->thumbnail,
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
        $lang = $request->lang ?? 'en';

        $slider = Slider::select([
            'id',
            'title_'.$lang.' as title',
            'link_'.$lang.' as link',
            'short_description_'.$lang.' as short_description',
            'thumbnail_'.$lang.' as thumbnail',
        ])->where('id',$id)->first();       
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
        $lang = $request->lang ?? 'en';
        $module = Slider::where('id',$id)->first();

        if(!$module){
            return response()->json([
                "status" => "error",
                "message" => "Record Not Found"
            ],403);
        }

        $validator = Validator::make($request->all(),
        [
            'title' => ['nullable','max:300'],
            'link' => ['nullable','max:300'],
            'short_description' => ['nullable','max:300'],
            'thumbnail' => ['nullable','max:300'],
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

        $module->{"title_" . $lang} = $request->title;
        $module->{"link_" . $lang} = $request->link;
        $module->{"short_description_" . $lang} = $request->short_description;
        $module->{"thumbnail_" . $lang} = $request->thumbnail;
        $module->sorting = $request->sorting;
        $module->status = $request->status;
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