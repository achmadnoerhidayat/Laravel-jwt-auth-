<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'api'], function(){
    Route::post('/login','LoginController@index');
    Route::post('/create','UserController@create');
    Route::get('/show','UserController@index');
    // untuk blog
    Route::post('/store','Blogcontroller@store');
    Route::get('/blog','Blogcontroller@index');
    Route::get('/blog/{id}','Blogcontroller@show');
    Route::put('/edit/{id}','Blogcontroller@edit');
    // buat comentar
    Route::post('coments/{blog_id}','ComentController@create');
});
