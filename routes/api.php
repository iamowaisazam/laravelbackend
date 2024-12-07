<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    // Route::get('/profile','ProfileController@profile')->name('login');

    //Registration
    Route::prefix('admin/auth')->namespace('App\Http\Controllers\V1')->group(function(){

        //Registration
        // Route::get('/social-login','LoginController@social_login');  
        Route::post('/register','LoginController@register');
        Route::post('/login','LoginController@login');

        // Route::get('/resend/email-verification/{email}','LoginController@resend_email_verification');
        // Route::get('/verify-email/{email}/token/{token}','LoginController@verify_email');

        //Password Reset
        // Route::get('/password-reset-request/{email}','PasswordResetController@password_reset_request');
        // Route::get('/password-reset-verify/{code}','PasswordResetController@password_reset_verify');
        // Route::post('/password-reset/{id}','PasswordResetController@password_reset');

        Route::get('/users','ProfileController@getUsers');
        
    });



    Route::prefix('web')->namespace('App\Http\Controllers\V1')->group(function () {

        Route::get('/settings/{id}','SettingController@show');
		Route::get('/settings','SettingController@index');

        Route::get('/posts','HomeController@posts');
        Route::get('/categories','HomeController@categories');
        Route::get('/posts_by_year','HomeController@posts_by_year');

        Route::get('/newsletter_list','SettingController@newsletter_list');
		Route::get('/newsletter_add','SettingController@newsletter_add');
        Route::get('/newsletter_remove','SettingController@newsletter_remove');
    });


    // Admin Panel
    Route::prefix('admin')->namespace('App\Http\Controllers\V1')->group(function () {

        Route::get('/profile','ProfileController@profile');
        Route::get('/logout', 'ProfileController@logout');

        Route::get('posts/pdf','PostController@pdf');
        Route::get('posts/post','PostController@index');
        Route::apiResource('posts','PostController');

        Route::get('filemanagers/search','FileManagerController@search');
        Route::apiResource('filemanagers','FileManagerController');
        Route::apiResource('settings','SettingController');

        // Route::post('filemanagers/update/{id}', 'FileManagerController@update');
        // Route::get('filemanagers/file/{id}', 'FileManagerController@get');
        // Route::post('filemanagers/store', 'FileManagerController@store');
        // Route::get('filemanagers/delete/{id}', 'FileManagerController@delete');
        // Route::get('filemanagera/index', 'FileManagerController@index');


        // Route::get('settings/get/{id}','SettingController@get');
        // Route::get('settings/update/{id}','SettingController@update');

        


      
        //Categories Management  
        // Route::get('/categories/action','CategoryController@action');
        // Route::get('/categories/search','CategoryController@search');
        // Route::apiResource('categories','CategoryController');

        //Files Upload
        // Route::post('filemanagers/update/{id}', 'FileManagerController@update');
        // Route::get('filemanagers/file/{id}', 'FileManagerController@get');
        // Route::post('filemanagers/store', 'FileManagerController@store');
        // Route::get('filemanagers/delete/{id}', 'FileManagerController@delete');
        // Route::get('filemanagers', 'FileManagerController@index');
        
    });



    //Front
    // Route::namespace('App\Http\Controllers\V1')->group(function () {
        
    //     //Home
    //     Route::get('/latest-products','HomeController@latest_products');
    //     Route::get('/featured-products','HomeController@featured_products');
    //     Route::get('/popular-products', 'HomeController@popular_products');
    //     Route::get('/featured-categories','HomeController@featured_categories');
    //     Route::get('/featured-brands', 'HomeController@featured_brands');
        
    //     // Shop
    //     Route::get('/stores','ShopController@stores');
    //     Route::get('/brands','ShopController@brands');
    //     Route::get('/tags','ShopController@tags');
    //     Route::get('/categories', 'ShopController@categories');
    
    //     Route::get('/products', 'ShopController@all_products');
    //     Route::get('/product-details/{id}','ShopController@product_details');
    //     Route::get('/product-reviews/{id}', 'ShopController@reviews');
    //     Route::get('/product-reviews/add/{id}', 'ShopController@add_reviews');
        
    //     // Reviews
                
    // });

    Route::fallback(function() {
        return response()->json([
            "message" => 'Invaled Route',
         ],404);
    });

// Route::get('/user', function (Request $request) {
    // return $request->user();
// })->middleware('auth:sanctum');