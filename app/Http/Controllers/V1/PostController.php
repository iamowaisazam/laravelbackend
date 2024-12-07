<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{


    public function pdf(Request $request)
    { 
        // dd($request->all());

        $lang = $request->lang ?? 'en';
        $sort_by = $request->sort_by ?? 'desc';
        $order_by = $request->order_by ?? 'id';
        $limit = $request->limit ?? 10;
        $page = $request->page ?? 1;


        //Query
        $data = Post::query();

        if($request->has('type')){
            $data->where('posts.type','pdf');
        }

        if($request->has('search') && $request->search != ''){
            $search = $request->search;
            $data->where('posts.title_'.$lang, 'like', '%'.$search.'%')
            ->orWhere('posts.author_'.$lang, 'like', '%'.$search.'%');
        }

        if($request->has('id') && $request->id){
            $data->where('posts.id',$request->id);
        }

        if($request->has('slug') && $request->slug){
            $data->where('posts.slug',$request->slug);
        }

        if($request->has('category') && $request->category){
            $data->where('posts.category_id',$request->category);
        }

        $total = $data->count(); 
        $data = $data->limit($limit)
        ->offset(($page - 1) * $limit)
        ->orderBy($order_by,$sort_by)
        ->select([
            'posts.id',
            'posts.slug',
            'posts.title_'.$lang.' as title',
            'posts.short_description_'.$lang.' as short_description',
            'posts.long_description_'.$lang.' as long_description',
            'posts.thumbnail_'.$lang.' as thumbnail',
            'posts.pdf_'.$lang.' as pdf',
            'posts.author_'.$lang.' as author',
            'posts.views_'.$lang.' as views',
            'posts.like_'.$lang.' as like',
            'posts.banner_'.$lang.' as banner',
            'posts.creater_'.$lang.' as creater',
            'posts.is_featured',
            'posts.status',
            'posts.type',
            'posts.created_at',
            'posts.updated_at'
        ])->get();

        $data->map(function ($item){
            if(isset($item['thumbnail'])){
                $item['thumbnail_prev'] = asset($item['thumbnail']);
            }    
            return $item;
        });

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

    /**
     * Show the profile for a given user.
     */
    public function index(Request $request)
    { 

        $lang = $request->lang ?? 'en';
        $sort_by = $request->sort_by ?? 'desc';
        $order_by = $request->order_by ?? 'id';
        $limit = $request->limit ?? 10;
        $page = $request->page ?? 1;

        //Query
        $data = Post::Leftjoin('categories','categories.id','=','posts.category_id');

        if($request->has('type')){
            $data->where('posts.type','post');
        }

        if($request->has('search') && $request->search != ''){
            $search = $request->search;
            $data->where('posts.title_'.$lang, 'like', '%'.$search.'%')
            ->orWhere('categories.title_'.$lang, 'like', '%'.$search.'%');
        }

        if($request->has('id') && $request->id){
            $data->where('posts.id',$request->id);
        }

        if($request->has('slug') && $request->slug){
            $data->where('posts.slug',$request->slug);
        }

        if($request->has('category') && $request->category){
            $data->where('posts.category_id',$request->category);
        }

        $total = $data->count(); 
        $data = $data->limit($limit)
        ->offset(($page - 1) * $limit)
        ->orderBy($order_by,$sort_by)
        ->select([
            'posts.id',
            'posts.slug',
            'categories.title_'.$lang.' as category',
            'posts.title_'.$lang.' as title',
            'posts.short_description_'.$lang.' as short_description',
            'posts.long_description_'.$lang.' as long_description',
            'posts.thumbnail_'.$lang.' as thumbnail',        
            'posts.is_featured',
            'posts.status',
            'posts.type',
            'posts.category_id',
            'posts.created_at',
            'posts.updated_at'
        ])->get();

        $data->map(function ($item){
            if(isset($item['thumbnail'])){
                $item['thumbnail_prev'] = asset($item['thumbnail']);
            }    
            return $item;
        });

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





    /*
     * Show the profile for a given user.
     */
    public function update(Request $request,$id)
    {

        $lang = $request->lang ?? 'en';
        $module = Post::where('id',$id)->first();
        if($module == false){
             $module = new Post();
        }

        if($request->has('title')){
            $module->{"title_" . $lang} = $request->title;
            $slug = strtolower($request->title);
            $slug = preg_replace('/[^a-z0-9-]/', ' ', $slug);
            $slug = preg_replace('/\s+/', '-', $slug);
            $slug = trim($slug, '-');
            $module->slug = $slug;
        }

        if($request->has('short_description')){
            $module->{"short_description_" . $lang} = $request->short_description;
        }

        if($request->has('long_description')){
            $module->{"long_description_" . $lang} = $request->long_description;
        }

        if($request->has('thumbnail')){
            $module->{"thumbnail_" . $lang} = $request->thumbnail;
        }

        if($request->has('banner')){
            $module->{"banner_" . $lang} = $request->banner;
        }

        if($request->has('creater')){
            $module->{"creater_" . $lang} = $request->creater;
        }

        if($request->has('author')){
            $module->{"author_" . $lang} = $request->author;
        }

        if($request->has('pdf')){
            $module->{"pdf_" . $lang} = $request->pdf;
        }

        if($request->has('status')){
            $module->status = $request->status;
        }

        if($request->has('featured')){
            $module->is_featured = $request->featured;
        }

       

        


        $module->type = $request->type;
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