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
    public function search(Request $request)
    { 

        $data = Post::query();
        if($request->has('search')){
            $search = $request->search;
            $data->where('title', 'like', '%'.$search.'%');
        }

        $data = $data->limit(5)->get();
        return response()->json([
           "message" => "Get All Product Successfully",
           "data" =>  $data,
        ],200);
    }



    /**
     * Show the profile for a given user.
     */
    public function index(Request $request)
    { 
        $per_page = 10;
        $sort_by = 'date';
        $assending = 'asc';
   
        $data = Post::query();

        if($request->has('search')){
            $search = $request->search;
            $data->where('title', 'like', '%'.$search.'%')
            ->orWhere('slug', 'like', '%'.$search.'%');
        }

        if($request->has('ascending') && $request->ascending != ''){
            $assending = $request->ascending;
        }

        if($request->has('sort_by') && $request->sort_by != null){
            $sort_by = $request->sort_by;
        }

        if($request->has('per_page') && is_numeric($request->per_page)){
            $per_page = $request->per_page;
        }

        switch ($sort_by) {

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

        $data = $data->with(['unit','category']);

        return response()->json([
            'query' => '',
            "message" => "Get All Product Successfully",
            "data" =>  $data->paginate($per_page),
        ],200);
    }



     /*
     * Show the profile for a given user.
     */
    public function show(Post $product)
    {       
        
         $product->unit;
         $product->category;
         
        return response()->json([
            "message" => 'Product Get Successfully',
            "data" => $product,
        ],200);
    }
    


    /*
     * Show the profile for a given user.
     */
    public function update(Request $request,$id)
    {

        if($id == 0){
            $module = New Post();    
        }else{
            $module = Post::where('id',$id)->first();
            if(!$module){
                return response()->json(["message" => "Record Not Found"],403);
            }
        }

        //-----------Validations

        if(request()->has('slug')){
            request()->merge(['slug' => Str::slug( request()->slug)]);
        } 


        $validations = [
            'title' => ['required','string'],
            'description' => ['nullable','string'],
            'short_description' => ['nullable','string'],
            'price' => ['required','integer'],
            'image' => ['nullable','image','mimes:jpeg,png,jpg','max:2048'],
            'images' => ['nullable','image','mimes:jpeg,png,jpg','max:2048'],
            'category_id' => ['nullable','integer','exists:categories,id'],
            'unit_id' => ['nullable','integer','exists:units,id'],
        ];

        if($id == 0){
            $validations['slug'] = ['required','unique:products,slug'];
            $validations['sku'] = ['required','string','unique:products,sku'];
        }else{
            $validations['slug'] = ['required','unique:products,slug,'.$id];
            $validations['sku'] = ['required','string','unique:products,sku,'.$id];
        }

        $validator = Validator::make($request->all(),$validations);
        if($validator->fails()){
            return response()->json([
                "message" => "Validation Failed",
                "data" => ["validations" => $validator->messages()],
            ],403);
        }

        //Validations
        $module->title = $request->title;
        $module->slug = $request->slug;
        $module->sku = $request->sku;
        $module->price = $request->price;
        $module->description = $request->description;
        $module->short_description = $request->short_description;
        

        if($request->has('active')){
            $module->active = $request->active;
         }

        if($request->has('category_id')){
           $module->category_id = $request->category_id;
        }

        if($request->has('unit_id')){
            $module->unit_id = $request->unit_id;
         }

        $module->save();

        //Response
        $message = $id ? 'Record Updated Successfully' : 'Record Created Successfully';
        return response()->json([
            "message" => $message,
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
             return response()->json(["message" => 'Record Deleted Successfully'],200);
        }
        
        $module->delete();
        return response()->json([
            "message" => 'Product Deleted Successfully',
            "data" => ['id' => $id]
        ],200);
    }


    
    /*
     * Remove the specified resource from storage.
     */
    public function action(Request $request)
    {
        if($request->has('idz') && $request->has('action') && $request->has('value')){
            
            $idz = explode(',',$request->idz);   
            
            switch ($request->action) {
            
                case 'delete':
                    

                case 'active':

                    $pp = Post::whereIn('id',$idz)->update(['active' => $request->value]);
                    return response()->json(['message' => "updated"],200);
                    break;
                
                default:
                break;
            }

        }

        return response()->json(['message' => __('Error Found')],400);
    }



// action

}