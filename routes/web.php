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

// Route::get('/about', function() {
//     return view('pages/about');
// });

//dynamic route
// Route::get('/users/{id}/{name}', function($id, $name) {
//     return 'This is user ' .$id .' and my name is ' .$name;
// });


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

Route::resource('posts', 'PostsController');

// Route::get('posts', 'PostsController@create');
// Route::post('posts', 'PostsController@store');