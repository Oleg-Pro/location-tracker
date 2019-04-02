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

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/locations-report', 'HomeController@locationsReport')->name('locations-report');


Route::get('/person-locations/{id}/date/{date?}', 'PersonController@personLocations')
    ->name('person-locations')
    ->where([
        'id' => '[0-9]+',
        /*'date' => '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/'*/]);
Route::resource('people', 'PersonController')->only('index', 'create', 'store', 'edit', 'update', 'destroy');