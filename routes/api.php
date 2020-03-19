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


Route::get('get-user-assign/{company}', 'API\CompanyController@getUserAssign');
Route::get('check-invitation', 'API\UserController@checkInvitation');
Route::get('get-list-companies', 'API\UserController@getListCompanies');
Route::put('accept/{company}', 'API\CompanyController@accept');
Route::post('enterCompany/{company}', 'API\UserController@enterCompany');
Route::put('layOff', 'API\UserController@layOff');
Route::put('retract', 'API\UserController@retract');


