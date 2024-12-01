<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    
    public function categories(Request $request)
    {

        $lang = $request->lang ?? 'es';
        $sort_by = 'asc';
        $limit = 10;

        $data = Category::query();

        if($request->has('search')){
            $search = $request->search;
            $data->where('title', 'like', '%'.$search.'%');
        }

        if($request->has('id') && $request->id){
            $data->where('id',$request->id);
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
            'is_featured',
            'status',
            'created_at',
            'updated_at'
        ])->get();

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


    public function posts(Request $request)
    {

        $lang = $request->lang ?? 'es';
        $sort_by = 'asc';
        $limit = $request->limit ?? 10;


        $data = Post::Leftjoin('categories','categories.id','=','posts.category_id');

        if($request->has('search')){
            $search = $request->search;
            $data->where('posts.title', 'like', '%'.$search.'%');
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

        if($request->has('type') && $request->type){
            $data->where('posts.type',$request->type);
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
            'posts.id',
            'posts.slug',
            'categories.title_'.$lang.' as category',
            'posts.title_'.$lang.' as title',
            'posts.short_description_'.$lang.' as short_description',
            'posts.long_description_'.$lang.' as long_description',
            'posts.thumbnail_'.$lang.' as thumbnail',
            'posts.pdf_'.$lang.' as pdf',
            'posts.author_'.$lang.' as author',

            'posts.views_'.$lang.' as views',
            'posts.like_'.$lang.' as like',

            'posts.banner_'.$lang.' as banner',
            

            'posts.is_featured',
            'posts.status',
            'posts.type',
            'posts.category_id',
            'posts.created_at',
            'posts.updated_at'
        ])->get();

        $data = $data->map(function ($item){
           
            $item['thumbnail_prev'] = asset($item['thumbnail']);

            $existingDate = $item->created_at;
            $date = Carbon::parse($existingDate);
            $formattedDate = $date->translatedFormat('d M Y');
            $relativeTime = $date->diffForHumans([
                'parts' => 1, // Show only the most significant part
                'short' => true, // Short format: "1 min."
            ]);
            $result = "{$formattedDate} - {$relativeTime}";
            $item['date_formated'] = $result;

            $item['date'] = $date->translatedFormat('d M Y');



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

    public function posts_by_year(Request $request)
    {

        $lang = $request->lang ?? 'es';
        $sort_by = 'asc';

        $data = Post::Leftjoin('categories','categories.id','=','posts.category_id');

        if($request->has('id') && $request->id){
            $data->where('posts.id',$request->id);
        }

        if($request->has('type') && $request->type){
            $data->where('posts.type',$request->type);
        }

        if($request->has('sort_by') && $request->sort_by != ''){
            $sort_by = $request->sort_by;
        }

        if($request->has('order_by') && $request->order_by != null){
            $data->orderBy($request->order_by,$sort_by);
        }

        $data = $data->select([
            'posts.id',
            'categories.title_'.$lang.' as category',
            'posts.title_'.$lang.' as title',
            'posts.short_description_'.$lang.' as short_description',
            'posts.long_description_'.$lang.' as long_description',
            'posts.thumbnail_'.$lang.' as thumbnail',
            'posts.pdf_'.$lang.' as pdf',
            'posts.author_'.$lang.' as author',
            'posts.is_featured',
            'posts.status',
            'posts.type',
            'posts.category_id',
            'posts.created_at',
            'posts.updated_at',
            DB::raw('YEAR(posts.created_at) as year')
        ])
        ->groupBy(DB::raw('YEAR(posts.created_at)'), 'posts.id')
        ->orderBy('year')
        ->get();

        
        $data = $data->map(function ($item){
            $item['thumbnail_prev'] = asset($item['thumbnail']);
            return $item;
        });


        return response()->json([
            'status' => 'success',
            "message" => "Get All Record Successfully",
            "data" =>  [
                'data' => $data->groupBy('year'),
            ],
        ],200);
        
    }


   


}