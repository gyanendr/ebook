<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppUserController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\OffersController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Product\ProductsController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\BrandController;
use App\Http\Controllers\Product\SubCategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;


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
		Route::get('/add-user', [AdminController::class, 'addUserForm'])->name('add-user');
		Route::post('/add-user', [AdminController::class, 'saveUserDetails'])->name('add-user');
		Route::get('/edit-user/{id}', [AdminController::class, 'editUser'])->name('edit-user');
		Route::post('/edit-user', [AdminController::class, 'updateUserDetails'])->name('edit-user');
		Route::get('/order-listing', [AdminController::class, 'orderListing'])->name('order-listing');
		
		Route::resource('brands', BrandController::class);
		
		Route::resource('products', ProductsController::class);
		
		Route::post('/getsubcategory', [ProductsController::class, 'getSubCategory'])->name('getSubCategory');
		
		Route::resource('subcategory', SubCategoryController::class);
	
		Route::resource('appuser', AppUserController::class);
	
		Route::resource('advertise', AdvertisementController::class);
		Route::get('ads-category', [AdvertisementController::class, 'adsCategory'])->name('ads-category');

		Route::resource('offer', OffersController::class);
		Route::resource('category', CategoryController::class);
		Route::get('/send-notification', [NotificationController::class, 'sendOfferNotification']);
			
});	


	Route::get('subscribe-process', [
    'as' => 'subscribe-process',
    'uses' => 'PaymentController@SubscribProcess'
	]);


	Route::get('subscribe-cancel', [
	    'as' => 'subscribe-cancel',
	    'uses' => 'PaymentController@SubscribeCancel'
	]);

	Route::get('subscribe-response', [
	    'as' => 'subscribe-response',
	    'uses' => 'PaymentController@SubscribeResponse'
	]);
