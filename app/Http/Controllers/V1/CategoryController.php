<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    
    /**
     * Show the profile for a given user.
     */
    public function search(Request $request)
    { 

        $data = Category::query();
        if($request->has('search')){
            $search = $request->search;
            $data->where('title', 'like', '%'.$search.'%');
        }
        
        
        // dd($data->get());
        
        
        $resData = [];
        foreach($data->get() as $key => $item){
            
           
            array_push($resData,[
              "id" => $item->id ,
              "label" => $item->title,
            ]);
            
            foreach($item->children as $child){
                array_push($resData,[
                  "id" => $child->id ,
                  "label" => '-- '.$child->title ,
                ]);
            }
            
            
            if(count($resData) >= 10){
                return response()->json([
                   "message" => "Get All Categories Successfully",
                   "data" =>  $resData,
                ],200);
            }
            
        }
        
        return response()->json([
           "message" => "Get All Categories Successfully",
           "data" =>  $resData,
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

        $data = Category::query()->where('parent_id',0)->with('children');

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
            "message" => "Get All Category Successfully",
            "data" =>  $data->paginate($per_page),
        ],200);
    }


    /*
     * Show the profile for a given user.
     */
    public function update(Request $request,$id)
    {

        if($id == 0){
            $module = New Category();    
        }else{
            $module = Category::where('id',$id)->first();
            if(!$module){
                return response()->json(["message" => "Record Not Found"],403);
            }
        }

        //-----------Validations
        // if(request()->has('slug')){
            // request()->merge(['slug' => Str::slug( request()->slug)]);
        // } 

        $validations = [
            'title' => ['required','string'],
            'description' => ['nullable','string'],
            'short_description' => ['nullable','string'],
        ];

        if($id == 0){
            $validations['slug'] = ['required','unique:categories,slug'];
        }else{
            $validations['slug'] = ['required','unique:categories,slug,'.$id];
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
        
        if($request->has('parent_id')){
            $module->parent_id = $request->parent_id;
        }
        
        if($request->has('description')){
            $module->description = $request->description;
        }
        
        if($request->has('image')){
            $module->image = $request->image;
        }
        
        if($request->has('featured')){
            $module->featured = $request->featured;
        }
        
        if($request->has('images')){
            $module->images = $request->images;
        }
        
        if($request->has('sort')){
            $module->sort = $request->sort;
        }
        
        if($request->has('short_description')){
            $module->short_description = $request->short_description;
        }

        if($request->has('active')){
            $module->active = $request->active;
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
    public function show(Category $category)
    {       
        
        return response()->json([
            "message" => 'Category Get Successfully',
            "data" => $category,
        ],200);
    }
    



    /**
     * Show the profile for a given user.
     */
    public function destroy(Category $category)
    {
        $id = $category->id;
        $category->delete();
      
        return response()->json([
            "message" => 'Category Deleted Successfully',
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

                    $pp = Category::whereIn('id',$idz)->update(['active' => $request->value]);
                    return response()->json(['message' => "updated"],200);
                    break;
                
                default:
                break;
            }

        }

        return response()->json(['message' => translate('Error Found')],400);
    }



}