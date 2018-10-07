<?php

/*
|--------------------------------------------------------------------------
| Static Routes
|--------------------------------------------------------------------------
|
| Get Static Images
|
*/

Route::get('/image/{code}/{name?}', 'ImageController@show')->name('showImage');
