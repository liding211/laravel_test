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

Route::get("/", "AdController@adsList");

Route::get("ads_sort/{order}", "AdController@adsList");

Route::match(['get', 'post'], "new_ad", "AdController@newAd");

Route::post("show_details", "AdController@showAdDetails");