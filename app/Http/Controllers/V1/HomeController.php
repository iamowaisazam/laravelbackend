<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Http\Resources\V1\Front\FeaturedProductsCollection;
use App\Models\Brand;

class HomeController extends Controller
{

    public function featured_products(Request $request)
    {
        $data = Product::where('featured',1)->limit(10)->get();
        return response()->json([
           "message" => '',
           "data" => $data,
        ],200);
    }

    public function latest_products(Request $request)
    {
        $data = Product::orderBy('created_at', 'desc')->limit(10)->get();
        return response()->json([
           "message" => '',
           "data" => $data,
        ],200);
    }

    public function popular_products(Request $request)
    {
        $data = Product::orderBy('created_at', 'desc')->limit(10)->get();
        return response()->json([
           "message" => '',
           "data" => $data,
        ],200);
    }


    public function featured_brands(Request $request)
    {

        $data = Brand::where('featured',1)->limit(10)->get();
        return response()->json([
           "message" => '',
           "data" => $data,
        ],200);
    }


    public function featured_categories(Request $request)
    {

        $data = [];
        $categories = Category::where('parent_id',0)->get();
        foreach($categories as $cat){
            array_push($data,[
                "id" => $cat->id,
                "title" => $cat->title,
                "count" => count(array_unique($cat->product_count())),
                "slug" => $cat->slug,
                "description" => $cat->description,
                "image" => $cat->image,
            ]);
        }
        
        return response()->json([
           "message" => '',
           "data" => $data,
        ],200);
    }

   


}