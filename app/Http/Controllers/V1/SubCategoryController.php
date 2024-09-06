<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{

    /**
     * Show the profile for a given user.
     */
    public function list(Request $request)
    { 
        $data = SubCategory::query();
        if($request->has('search')){
            $search = $request->search;
            $data->where('title', 'like', '%'.$search.'%');
        }

        $data = $data->limit(5)->get();
        return response()->json([
           "message" => "Get All SubCategory Successfully",
           "data" =>  $data,
        ],200);
    }



    /**
     * Show the profile for a given user.
     */
    public function index(Request $request)
    { 
        $per_page = 10;
        $order_by = 'date';
        $assending = 'asc';

        $data = SubCategory::query()->with('category');

        if($request->has('search')){
            $search = $request->search;
            $data->where('title', 'like', '%'.$search.'%')
            ->orWhere('slug', 'like', '%'.$search.'%');
        }

        if($request->has('ascending')){
            $assending = $request->ascending;
        }

        if($request->has('order_by')){
            $order_by = $request->order_by;
        }

        if($request->has('per_page') && is_numeric($request->per_page)){
            $per_page = $request->per_page;
        }

        switch ($order_by) {

            case 'title':
                $data->orderBy('title',$assending);
                break;

            case 'date':
                $data->orderBy('created_at',$assending);
                break;

            case 'id':
                $data->orderBy('id',$assending);
                break;        

            default:
               $data->orderBy('created_at',$assending);
            break;
        }

        return response()->json([
            "message" => "Get All SubCategory Successfully",
            "data" =>  $data->paginate($per_page),
        ],200);
    }




    /*
     * Show the profile for a given user.
     */
    public function store(Request $request)
    {
        if(request()->has('slug')){
            request()->merge(['slug' => Str::slug( request()->slug)]);
        } 

        $validator = Validator::make($request->all(),[
            'title' => ['required','string','min:5','max:30'],
            'slug' =>['required','string','unique:subcategories,slug','min:5','max:30'],
            'category_id' => ['required','integer','exists:categories,id'],
            'description' => ['nullable','string','max:300'],
            'excerpt' => ['nullable','string','max:100'],
            'thumbnail' => ['image','mimes:jpeg,png,jpg','max:2048'],
        ]);
        
        if($validator->fails()){
            return response()->json([
                "message" => "Validation Failed",
                "data" => ["validations" => $validator->messages()],
            ],403);
        }

        $subcategory = SubCategory::create([        
            "title" => $request->title,
            "slug" =>  $request->slug,
            "category_id" =>  $request->category_id,
            "description" =>  $request->has('description') ? $request->description: null,
            "excerpt" =>  $request->has('excerpt') ? $request->excerpt : null,
        ]);

        return response()->json([
            "message" => 'SubCategory Created Successfully',
            "data" => $subcategory,
        ],200);

    }


     /*
     * Show the profile for a given user.
     */
    public function show(SubCategory $subcategory)
    {   

        $subcategory->category;

        return response()->json([
            "message" => 'SubCategory Get Successfully',
            "data" => $subcategory,
        ],200);
    }
    

    /*
     * Show the profile for a given user.
     */
    public function update(Request $request,SubCategory $subcategory)
    {
        if(request()->has('slug')){
            request()->merge(['slug' => Str::slug( request()->slug)]);
        } 

        $validator = Validator::make($request->all(),[
            'title' => ['required','string','min:5','max:30'],
            'slug' =>['required','unique:subcategories,slug,'.$subcategory->id,'min:3','max:30'],
            'category_id' => ['required','integer','exists:categories,id'],
            'description' => ['nullable','string','max:300'],
            'excerpt' => ['nullable','string','max:100'],
            'thumbnail' => ['image','mimes:jpeg,png,jpg','max:2048'],
        ]);
        
        if($validator->fails()){
            return response()->json([
                "message" => "Validation Failed",
                "data" => ["validations" => $validator->messages()],
            ],403);
        }

        $subcategory->title = $request->title;
        $subcategory->slug = $request->slug;
        $subcategory->category_id = $request->category_id;
        $subcategory->description = $request->has('description') ? $request->description : null;
        $subcategory->excerpt = $request->has('excerpt') ? $request->excerpt : null;

        if($request->has('thumbnail')){
            $subcategory->thumbnail = $request->thumbnail;
        }
         
        $subcategory->save();
    
        return response()->json([
            "message" => 'SubCategory Update Successfully',
            "data" => $subcategory,
        ],200);
    }


    /**
     * Show the profile for a given user.
     */
    public function destroy(SubCategory $subcategory)
    {
        $id = $subcategory->id;
        $subcategory->delete();
      
        return response()->json([
            "message" => 'SubCategory Deleted Successfully',
            "data" => ['id' => $id]
        ],200);
    }

}