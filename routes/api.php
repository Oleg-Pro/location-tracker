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

Route::apiResource('person-locations', 'Api\v1\PersonLocationController');
Route::apiResource('people', 'Api\v1\PersonController');
