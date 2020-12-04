<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/new', 'TestController@welcome');
Route::any('{slug}',function (){
    return view('welcome');
});
Route::post('/app/addTag', 'AdminController@addTag');
Route::post('/app/editTag', 'AdminController@editTag');
Route::post('/app/deleteTag', 'AdminController@deleteTag');
Route::post('/app/upload', 'AdminController@upload');
Route::post('/app/deleteImage', 'AdminController@deleteImage');
Route::get('/app/getTag', 'AdminController@getTag');

Route::post('/app/addCategory', 'AdminController@addCategory');
Route::get('/app/getCategory', 'AdminController@getCategory');
Route::post('/app/deleteCategory', 'AdminController@deleteCategory');
Route::post('/app/editCategory', 'AdminController@editCategory');
