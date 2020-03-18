<?php

use Illuminate\Http\Request;

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

Route::apiResources(['user' => 'API\UserController']);
Route::get('profile', 'API\UserController@profile');
Route::get('findUser', 'API\UserController@search');
Route::put('profile', 'API\UserController@updateProfile');

Route::resource('jobs', 'API\JobController');
Route::resource('companies', 'API\CompanyController');

Route::get('get-info', 'API\UserController@getInfo');
Route::get('get-free-user/{company}', 'API\UserController@getFreeUser');
Route::put('invite/{company}', 'API\CompanyController@invite');

Route::post('accept/{company}', 'API\UserController@accept');
Route::post('refuse/{company}', 'API\UserController@refuse');
Route::put('layOff', 'API\UserController@layOff');

