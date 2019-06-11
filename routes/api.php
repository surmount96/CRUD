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

// List Fuel Inventories
Route::get('fuels','FuelController@index');

//Showing just single fuel inventory
Route::get('fuel/{id}','FuelController@show');

// Create new Inventory
Route::post('fuel','FuelController@store');

// Update Fuel Inventory
Route::put('fuel','FuelController@store');

// Delete Fuel Inventory
Route::delete('fuels/{id}','FuelController@destroy');
