<?php

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;

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
//      return $request->user('api');
//      return auth('api')->user();
//      return Auth::guard('api')->user();
    return $request->user();
});

Route::apiResource('people', 'Api\v1\PersonController');
Route::get('/person-locations/{id}/date/{date?}', 'Api\v1\PersonLocationController@personLocationsByDate')
    ->name('person-locations')
    ->where([
        'id' => '[0-9]+',
        'date' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])']);

Route::apiResource('person-locations', 'Api\v1\PersonLocationController');
