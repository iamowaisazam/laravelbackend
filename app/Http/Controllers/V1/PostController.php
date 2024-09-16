<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{

  


      /**
     * Show the profile for a given user.
     */
    public function index(Request $request)
    { 
        
        $lang = $request->lang ?? 'en';
        $sort_by = 'asc';
        $limit = 10;

     
        $data = Post::query();

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
            'short_description_'.$lang.' as short_description',
            'long_description_'.$lang.' as long_description',
            'thumbnail_'.$lang.' as thumbnail',
            'is_featured',
            'status',
            'created_at',
            'updated_at'
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
        $validator = Validator::make($request->all(),
        [
            'title' => ['required','max:100'],
            'thumbnail' => ['nullable','max:100'],
            'short_description' => ['required','max:300'],
            'long_description' => ['nullable','max:1000'],
            'type' => ['required','max:300'],
            'featured' => ['required','integer','max:300'],
            'sorting' => ['nullable','integer','max:300'],
            'status' => ['required','integer','max:300'],
            'lang' => ['required','in:en,es,pt','max:300'],
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => "Validation Failed",
                "errors" =>  $validator->messages(),
            ],403);
        }

        $lang = $request->lang;


        $slug = strtolower($request->title);
        $slug = preg_replace('/[^a-z0-9-]/', ' ', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = trim($slug, '-');

        $module = new Post();
        $module->slug = $slug;

        $module->{"title_" . $lang} = $request->title;
        $module->{"short_description_" . $lang} = $request->short_description;
        $module->{"long_description_" . $lang} = $request->long_description;
        $module->{"thumbnail_" . $lang} = $request->thumbnail;
        $module->sorting = $request->sorting;
        $module->type = 'post';
        $module->is_featured = $request->featured;
        $module->status = $request->status;
        $module->save();

        return response()->json([
            "message" => "Record Created Successfully",
            "data" => ['id' => $module->id]
        ],200);


    }


    /*
     * Show the profile for a given user.
     */
    public function update(Request $request,$id)
    {

        $module = Post::where('id',$id)->first();
        if(!$module){
            return response()->json(["message" => "Record Not Found"],403);
        }

        $validator = Validator::make($request->all(),
        [
            'title' => ['required','max:100'],
            'thumbnail' => ['nullable','max:100'],
            'short_description' => ['required','max:300'],
            'long_description' => ['nullable','max:1000'],
            'type' => ['required','max:300'],
            'sorting' => ['nullable','integer','max:300'],
            'featured' => ['required','integer','max:300'],
            'status' => ['required','integer','max:300'],
            'lang' => ['required','in:en,es,pt','max:300'],
        ]);

        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => "Validation Failed",
                "errors" =>  $validator->messages(),
            ],403);
        }

        $lang = $request->lang ?? 'en';

        $module->{"title_" . $lang} = $request->title;
        $module->{"short_description_" . $lang} = $request->short_description;
        $module->{"long_description_" . $lang} = $request->long_description;
        $module->{"thumbnail_" . $lang} = $request->thumbnail;
        
        // $module->sorting = $request->sorting;
        // $module->type = 'post';

        $module->is_featured = $request->featured;
        $module->status = $request->status;
        
        $module->save();

        return response()->json([
            "message" => "Record Updated Successfully",
            "data" => ['id' => $module->id]
        ],200);

    }

    public function show($id,Request $request )
    {
        $lang = $request->lang ?? 'en';

        $slider = Post::select([
            'id',
            'title_'.$lang.' as title',
            'short_description_'.$lang.' as short_description',
            'long_description_'.$lang.' as long_description',
            'thumbnail_'.$lang.' as thumbnail',
            'is_featured',
            'status',
            'created_at',
            'updated_at'
        ])->where('id',$id)->first();       
        return response()->json([
            "message" => 'Get Record Successfully',
            "data" => $slider,
        ],200);
    }



    /*
     * Show the profile for a given user.
     */
    public function destroy($id)
    {
        $module = Post::find($id);
        if($module == null){
             return response()->json(["message" => 'Record Not Found'],403);
        }
        
        $module->delete();
        return response()->json([
            "message" => 'Record Deleted Successfully',
            "data" => ['id' => $id]
        ],200);
    }


    
}