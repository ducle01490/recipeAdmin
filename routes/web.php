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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', array('as' => 'homepage', 'uses' => 'OrderController@list'));

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'recipes'], function () {
	// Lay danh sach recipes
	Route::get('list', array('as' => 'get_list_recipes', 'uses' => 'RecipeController@list'));

	Route::any('add', array('as' => 'post_add_recipe', 'uses' => 'RecipeController@add'));
});

Route::group(['prefix' => 'orders'], function () {
	// Lay danh sach recipes
	Route::get('list', array('as' => 'get_list_orders', 'uses' => 'OrderController@list'));
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
