<?php

use Illuminate\Support\Facades\Route;

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



Auth::routes();
Route::get('/' , 'RecipesController@index');
Route::get('/home' , 'RecipesController@index');
Route::get('/home/new', 'RecipesController@index2');
Route::resource('new' , 'NewController');
Route::resource('recipes', 'RecipesController');
Route::get('food/meat', 'FoodController@meat');
Route::get('/food/fish', 'FoodController@fish');
Route::get('/food/vegetarian', 'FoodController@vegetarian');
Route::get('/food/dessert', 'FoodController@dessert');
Route::get('/food/soup', 'FoodController@soup');
