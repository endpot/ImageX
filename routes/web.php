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

Route::get('/', 'HomeController@index');

Route::get('/upload', function () {
    return view('upload', ['current' => 'upload']);
});

Route::get('/doc', function () {
    return view('doc', ['current' => 'doc']);
});

Route::get('/about', function () {
    return view('about', ['current' => 'about']);
});

Route::get('delete/{deleteCode}', 'ImageController@destroy')->name('deleteImage');
