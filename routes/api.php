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

Route::post('register', 'API\UserController@register');
Route::post('login', 'API\UserController@login');

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::middleware('auth:api')->group( function () {
	Route::get('user', 'API\UserController@details');

    Route::resource('customers', 'API\CustomerController');
	Route::resource('suppliers', 'API\SupplierController');
	Route::resource('employees', 'API\EmployeeController');
	Route::resource('categories', 'API\CategoriesController');
	Route::resource('producttypes', 'API\ProducttypesController');
	Route::get('prodtypecategory/{id}', 'API\ProducttypesController@showprodtypebyid');
	Route::resource('products', 'API\ProductController');
	Route::get('productptype/{id}', 'API\ProductController@showprodbyid');
	Route::get('showptypebycatid/{id}', 'API\ProducttypesController@showptypebycatid');
	Route::get('showproducttype', 'API\ProducttypesController@showproducttype');
	Route::resource('warehouses', 'API\WarehouseController');
	Route::resource('productUomformula','API\ProductUomformulaController');
	Route::put('productUomformula/{id}', 'ProductUomformulaController@update');
	Route::get('showproduombyptypeid/{id}', 'API\ProductUomformulaController@showproduombyptypeid');
	Route::get('showproduom/{id}', 'API\ProductUomformulaController@show');
	Route::put('productUomformula/{id}', 'ProductUomformulaController@update');
	Route::resource('purorders', 'API\PurorderController');
	Route::post('purorderdtls', 'API\PurorderController@storepurordrdtls');
	Route::resource('productqnties', 'API\ProductqntyController');
	//Route::put('productqnties/{id}', 'API\ProductqntyController@update');
});

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
