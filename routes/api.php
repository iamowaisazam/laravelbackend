<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


  // User Routes

 Route::namespace('Api')->middleware('CheckApi')->group(function () {

    // Auth Routes
    Route::post('/login','AuthController@login');
    Route::post('/auth','AuthController@auth');
    Route::post('/logout','AuthController@logout');
    Route::post('/profile/update','AuthController@update');
    Route::post('/register','AuthController@register');
    Route::post('/checkout','AuthController@checkout');
   
    
    


    Route::post('/file/upload','AuthController@file');
   
   //User Routes
    Route::get('/users/get/{id}','UserController@get');
    Route::post('/users/create','UserController@create');
    Route::post('/users/update','UserController@update');
    Route::get('/users/delete/id','UserController@delete');

    // User Routes
    Route::get('/users/all','UserController@all');
});


// Route::middleware('auth:api')->get('/user', function (Request $request) {
// //    return $request->user();
// });