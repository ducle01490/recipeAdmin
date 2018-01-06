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

Route::get('/home', array('as' => 'home', 'uses' => 'OrderController@list'));

// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'recipes'], function () {
	// Lay danh sach recipes
	Route::get('list', array('as' => 'get_list_recipes', 'uses' => 'RecipeController@list'));
	Route::any('add', array('as' => 'post_add_recipe', 'uses' => 'RecipeController@add'));
	Route::any('update/{recipeId}/status/{status}', array('as' => 'update_recipe_status', 'uses' => 'RecipeController@updateStatus'));
	Route::any('edit/{recipeId}', array('as' => 'post_update_recipe', 'uses' => 'RecipeController@edit'));
	Route::any('delete/{recipeId}', array('as' => 'delete_recipe', 'uses' => 'RecipeController@delete'));
});

Route::group(['prefix' => 'orders'], function () {
	// Lay danh sach recipes
	Route::get('list', array('as' => 'get_list_orders', 'uses' => 'OrderController@list'));
	Route::any('add', array('as' => 'create_order', 'uses' => 'OrderController@add'));
	Route::any('edit/{orderId}', array('as' => 'post_update_order', 'uses' => 'OrderController@edit'));
	
});

Route::group(['prefix' => 'menus'], function () {
	// Lay danh sach recipes
	Route::get('list/{serving}', array('as' => 'get_list_menus', 'uses' => 'PlanController@list'));
	Route::any('add', array('as' => 'create_menu', 'uses' => 'PlanController@add'));
	Route::any('update/{menuId}/status/{status}', array('as' => 'update_menu_status', 'uses' => 'PlanController@updateStatus'));
	Route::any('update/{menuId}/publish/{date}', array('as' => 'update_menu_publish_date', 'uses' => 'PlanController@publishMenuDate'));
	Route::any('edit/{menuId}', array('as' => 'post_update_menu', 'uses' => 'PlanController@edit'));
	Route::any('delete/{menuId}', array('as' => 'delete_menu', 'uses' => 'PlanController@delete'));
});

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::post('image-upload', array('as' => 'post_upload_image', 'uses' => 'UploadController@imageUpload'));
