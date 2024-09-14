<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class FileManagerController extends Controller
{
    
     public function index(Request $request)
    {
        
        $per_page = 10;
        $sort = 'date-asc';
        $assending = 'asc';
   
        $data = FileManager::query();

        if($request->has('search')){
            $search = $request->search;
            $data->where('title', 'like', '%'.$search.'%')->orWhere('extension', 'like', '%'.$search.'%');
        }

        if($request->has('ascending') && $request->ascending != ''){
            $assending = $request->ascending;
        }

        if($request->has('sort') && $request->sort != null){
            $sort = $request->sort;
        }

        if($request->has('per_page') && is_numeric($request->per_page)){
            $per_page = $request->per_page;
        }

        switch ($sort) {

            case 'size-desc':
                $data->orderBy('size','desc');
                break;
                
            case 'size-asc':
                $data->orderBy('size','asc');
                break;    

            case 'date-asc':
                $data->orderBy('created_at','asc');
                break;
                
            case 'date-desc':
                $data->orderBy('created_at','desc');
                break;    


            default:

               $data->orderBy('created_at',$assending);
            break;
        }


        return response()->json([
            'query' => '',
            "message" => "Records Get  Successfully",
            "data" =>  $data->paginate($per_page),
        ],200);
        
        
       
    }


    public function store(Request $request){
    
    
        // $validator = Validator::make($request->all(), [
        //     'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        // ]);
        
        // if ($validator->fails()) {
            // return response()->json([
                    //  'message' => 'Validation Failed',
                    //  'data' => [ 'validations' => $validator->messages()],
            // ],401);
        // }

        if(!$request->hasFile('file')){
            return response()->json([
                     'message' => 'File Not Found',
            ],401);
        }

        $file =  $request->file;
        $orignalName = $file->getClientOriginalName();
        $extension = strtolower($file->extension());
        $size = $file->getSize();
        $dir = public_path('uploads');
        $newFileName = rand(10000000000, 9999999999) . date("YmdHis") . "." . $extension;
        
        $upload = FileManager::create([
            "title" => $orignalName,
            "orignal_name" => $orignalName,
            "name" => $newFileName,
            "extension" => $extension,
            "access_type" => "global",
            "size" => $size,
            "path" =>  "uploads/".$newFileName,
            "created_by" =>  0,
            "link" => asset("/uploads/".$newFileName),
        ]);
        $file->move($dir,$newFileName);

        return response()->json([
            'message' => "Uploaded Successfully",
            "data" => [
                'link' => $upload->link
            ]
        ]);
        
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'message' => $e->getMessage(),
        //     ]);
        // }

    }


    public function get(Request $request, $id)
    {

        // $user = $request->user();
        $upload = FileManager::find($id);
       
        if($upload == null){
            return response()->json([
                "message" => "File Not Found" ,
            ],400);
        }

        // if($user->id != $upload->user_id){
        //     return response()->json([
        //         "message" => "Unauthorized" ,
        //     ],400);
        // }

        if(! File::exists(public_path($upload->file_name))){
            return response()->json([
                "message" => "File Not Found" ,
            ],400);
        }


        return response()->json([
            "message" => "File Get Successfully" ,
            "data" => $upload,
        ],200);

    }
    
     public function update(Request $request, $id)
    {

        $upload = FileManager::find($id);
        if($upload == null){
            return response()->json([
                "message" => "File Not Found" ,
            ],400);
        }
        
        $upload->title = $request->title;
        $upload->description = $request->description;
        $upload->save();
        
        if(! File::exists(public_path($upload->file_name))){
            return response()->json([
                "message" => "File Not Found" ,
            ],400);
        }


        return response()->json([
            "message" => "File Get Successfully" ,
            "data" => $upload,
        ],200);

    }

    public function delete(Request $request,$id)
    {
        // $user = $request->user();
        $upload = FileManager::find($id);
       
        if($upload == null){
            return response()->json([
                "message" => "Not Found" ,
            ],400);
        }

        // if($user->id != $upload->user_id){
        //     return response()->json([
        //         "message" => "Unauthorized" ,
        //     ],400);
        // }

        if(! File::exists(public_path('uploads/all/'.$upload->name))){
            return response()->json([
                "message" => "File Exist In Directory" ,
            ],400);
        }

        if(! File::delete(public_path("uploads/all/".$upload->name))){
            return response()->json([
                "message" => "File Not Deleted" ,
            ],400); 
        }
        
        $upload->delete();

        return response()->json([
            "message" => "File Successfully Deleted",
            "data" => $id,
        ],200);
    
    }


   

    

}