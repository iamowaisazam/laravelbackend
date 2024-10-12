<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class FileManagerController extends Controller
{
    
     /**
     * Show the profile for a given user.
     */
    public function search(Request $request)
    { 

        $data = FileManager::query();

        if($request->has('search')){
            $search = $request->search;
            $data->where('title', 'like', '%'.$search.'%');
        }

        $data = $data->select([
            'id',
            'title',
            'link'
        ])
        ->limit(10)
        ->get();

        //  $data = $data->map(function ($item){
            // $item['thumbnail_prev'] = asset($item['thumbnail']);
            // return $item;
        // });

        return response()->json([
            'status' => 'success',
            "message" => "Get All Record Successfully",
            "data" =>  $data
        ],200);
    
    }

      /**
     * Show the profile for a given user.
     */
    public function index(Request $request)
    { 
        
        $lang = $request->lang ?? 'en';
        $sort_by = 'asc';
        $limit = 100;

     
        $data = FileManager::query();

        if($request->has('search')){
            $search = $request->search;
            $data->where('name', 'like', '%'.$search.'%');
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
        ->select('*')
        ->get();

        // $data = $data->map(function ($item){
        //     $item['thumbnail_prev'] = asset($item['thumbnail']);
        //     return $item;
        // });

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
        $filename = $request->filename;
        $extension = strtolower($file->extension());
        $size = $file->getSize();
        $dir = public_path('uploads');

        $newPath = rand(10000000000, 9999999999) . date("YmdHis") . "." . $extension;
        $newFileName = $filename;
        
        $upload = FileManager::create([
            "name" => $newFileName,
            "extension" => $extension,
            "access_type" => "global",
            "size" => $size,
            "path" =>  "uploads/".$newPath,
            "created_by" =>  0,
            "link" => asset("/uploads/".$newPath),
        ]);

        $file->move($dir,$newPath);

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
        
        $upload->name = $request->name;
        // $upload->description = $request->description;
        $upload->save();
        
        // if(! File::exists(public_path($upload->file_name))){
        //     return response()->json([
        //         "message" => "File Not Found" ,
        //     ],400);
        // }


        return response()->json([
            "message" => "File Get Successfully" ,
            "data" => $upload,
        ],200);

    }

    public function destroy(Request $request,$id)
    {
        // $user = $request->user();
        $upload = FileManager::find($id);
       
        if($upload == null){
            return response()->json([
                "message" => "Not Found" ,
            ],400);
        }

        if(! File::exists(public_path($upload->path))){
            // return response()->json([
                // "message" => "File Exist In Directory" ,
            // ],400);
        }

        if(! File::delete(public_path($upload->name))){
            // return response()->json([
                // "message" => "File Not Deleted" ,
            // ],400); 
        }
        
        $upload->delete();

        return response()->json([
            "message" => "File Successfully Deleted",
            "data" => $id,
        ],200);
    
    }


   

    

}