<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Product\ProductsController;
use App\Http\Controllers\Product\BrandController;
use App\Http\Controllers\Product\SubCategoryController;


Route::get('/', function () {

    return redirect('login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(
	[
		'prefix' => 'user',  //link url parameter
		'namespace' => 'User', //folder
		'middleware' => 'App\Http\Middleware\UserMiddleware'
	], function() {
		Route::match(['get', 'post'], '/', 'App\Http\Controllers\User\UserController@index');
		Route::get('/dashboard', [UserController::class, 'index'])->name('index');
	});

Route::group(
	[
		'prefix' => 'admin',  //link url parameter
		//'namespace' => 'Admin', //folder
		'middleware' => 'App\Http\Middleware\AdminMiddleware'
	], function() {
		Route::match(['get', 'post'], '/', 'App\Http\Controllers\Admin\AdminController@index');
		
		Route::get('/dashboard', [AdminController::class, 'index'])->name('index');
		
		Route::get('/user-listing', [AdminController::class, 'usersListing'])->name('user-listing');
		Route::get('/order-listing', [AdminController::class, 'orderListing'])->name('order-listing');
		
		Route::resource('brands', BrandController::class);
		
		Route::resource('products', ProductsController::class);
		
		Route::post('/getsubcategory', [ProductsController::class, 'getSubCategory'])->name('getSubCategory');
		
		Route::resource('subcategory', SubCategoryController::class);
			


		
});	
