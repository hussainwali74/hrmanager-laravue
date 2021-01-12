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

Route::post('/app/addTag', 'AdminController@addTag');
Route::post('/app/editTag', 'AdminController@editTag');
Route::post('/app/deleteTag', 'AdminController@deleteTag');
Route::post('/app/upload', 'AdminController@upload');
Route::post('/app/deleteImage', 'AdminController@deleteImage');
Route::get('/app/getTag', 'AdminController@getTag');

Route::get('/app/getCategory', 'AdminController@getCategory');

//employees
Route::post('/app/addEmployee', 'AdminController@addEmployee');
Route::get('/app/getEmployees', 'AdminController@getEmployees');
Route::post('/app/deleteEmployee', 'AdminController@deleteEmployee');
Route::post('/app/editEmployee', 'AdminController@editEmployee');

//Login
Route::post('/app/login', 'AdminController@adminLogin');
Route::post('/app/resetPassword', 'AdminController@resetPassword');

Route::post('/app/addVacation', 'AdminController@addVacation');
Route::get('/app/getEmployeeVacations', 'AdminController@getEmployeeVacations');

Route::get('/logout', 'AdminController@logout');
Route::get('/', 'AdminController@index');
Route::any('{slug}', 'AdminController@index');