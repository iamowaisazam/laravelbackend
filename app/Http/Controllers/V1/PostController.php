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
        $per_page = 10;
        $sort_by = 'asc';
     
        $data = Post::query();

        if($request->has('search')){
            $search = $request->search;
            $data->where('title', 'like', '%'.$search.'%');
            // ->orWhere('lang', 'like', '%'.$search.'%');
        }

        if($request->has('sort_by') && $request->sort_by != ''){
            $sort_by = $request->sort_by;
        }

        if($request->has('per_page') && is_numeric($request->per_page)){
            $per_page = $request->per_page;
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

        $data = $data->paginate($per_page);

        return response()->json([
            "status" => "success",
            "message" => "Get All Records Successfully",
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
            
            'short_description' => ['nullable','max:300'],
            'short_description_es' => ['nullable','max:300'],
            'short_description_pt' => ['nullable','max:300'],

            'long_description' => ['nullable','max:1000'],
            'long_description_es' => ['nullable','max:1000'],
            'long_description_pt' => ['nullable','max:1000'],

            'type' => ['required','in:post','max:300'],
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

       $module = Post::create([
            'title' => $request->title,
            'slug' => $request->title,
            'title_es' => $request->title_es,
            'title_pt' => $request->title_pt,
            
            'short_description' => $request->short_description,
            'short_description_es' => $request->short_description_es,
            'short_description_pt' => $request->short_description_et,

            'long_description' => $request->long_description,
            'long_description_es' => $request->long_description_es,
            'long_description_pt' => $request->long_description_es,

            'type' => $request->type,
            'sorting' => $request->sorting,
            'status' => $request->status,
        ]);

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
            'title' => ['required','max:300'],
            'title_es' => ['nullable','max:300'],
            'title_pt' => ['nullable','max:300'],
            
            'short_description' => ['nullable','max:300'],
            'short_description_es' => ['nullable','max:300'],
            'short_description_pt' => ['nullable','max:300'],

            'long_description' => ['nullable','max:1000'],
            'long_description_es' => ['nullable','max:1000'],
            'long_description_pt' => ['nullable','max:1000'],

            'type' => ['required','in:post','max:300'],
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
        $module->slug = $request->title;
        $module->title_es = $request->title_es;
        $module->title_pt = $request->title_pt;
        
        $module->short_description = $request->short_description;
        $module->short_description_es = $request->short_description_es;
        $module->short_description_pt = $request->short_description_et;

        $module->long_description = $request->long_description;
        $module->long_description_es = $request->long_description_es;
        $module->long_description_pt = $request->long_description_es;

        $module->type = $request->type;
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