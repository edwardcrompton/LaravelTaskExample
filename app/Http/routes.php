<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/tasks', 'TaskController@index');

Route::post('/task', 'TaskController@store');

Route::get('/task/{task}/edit', 'TaskController@edit');

Route::post('/task/{task}/update', 'TaskController@update');

Route::delete('/task/{task}/delete', 'TaskController@destroy');

// RESTful API endpoint
// Route group for API versioning
Route::group(array('prefix' => 'api/v1'), function()
{
    Route::resource('task/add', 'TaskRestController@add');
});


