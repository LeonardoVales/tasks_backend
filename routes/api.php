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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('users/create', 'UsersController@create'); //Create User
Route::post('login', 'AuthController@login'); //Login

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('users', 'UsersController@index');

    Route::get('tasks/{date?}', 'TasksController@index');
    Route::post('tasks/create', 'TasksController@create');
    Route::delete('tasks/delete/{id}', 'TasksController@delete');
    Route::put('tasks/toggle/{id}', 'TasksController@toggleTask');
    
});