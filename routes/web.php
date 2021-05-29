<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\UserController;

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
		Route::get('/order-new-book', [UserController::class, 'orderNewBook'])->name('order-new-book');
		Route::get('/borrow-book/{id}', [UserController::class, 'borrowBook'])->name('borrow-book');
		Route::post('/order-book', [UserController::class, 'orderBook'])->name('order-book');
		Route::get('/return-book/{id}', [UserController::class, 'returnBook'])->name('return-book');
		Route::post('/pay-penalty', [UserController::class, 'payPenalty'])->name('pay-penalty');
	});

Route::group(
	[
		'prefix' => 'admin',  //link url parameter
		'namespace' => 'Admin', //folder
		'middleware' => 'App\Http\Middleware\AdminMiddleware'
	], function() {
		Route::match(['get', 'post'], '/', 'App\Http\Controllers\Admin\AdminController@index');
		
		Route::get('/dashboard', [AdminController::class, 'index'])->name('index');
		
		Route::get('/user-listing', [AdminController::class, 'usersListing'])->name('user-listing');
		Route::get('/order-listing', [AdminController::class, 'orderListing'])->name('order-listing');
		
		
		/****************************  Category functionality   *************************************/		
		
		Route::get('/category-listing', [AdminController::class, 'categoryListing'])->name('category-listing');
		Route::get('/add-category', [AdminController::class, 'addCategory'])->name('add-category');
		Route::post('/add-category', [AdminController::class, 'saveCategoryDetails'])->name('add-category');
		Route::get('/edit-category/{id}', [AdminController::class, 'editCategory'])->name('edit-category');
		Route::post('/update-category', [AdminController::class, 'updateCategory'])->name('update-category');
		Route::get('/delete-category/{id}',[AdminController::class, 'deleteCategory'])->name('delete-category');
		
		/****************************  Category functionality End  *************************************/	

		/****************************  Book functionality   *************************************/		
		
		Route::get('/book-listing', [AdminController::class, 'bookListing'])->name('book-listing');
		Route::get('/add-book', [AdminController::class, 'addbook'])->name('add-book');
		Route::post('/add-book', [AdminController::class, 'savebookDetails'])->name('add-book');
		Route::get('/edit-book/{id}', [AdminController::class, 'editbook'])->name('edit-book');
		Route::post('/update-book', [AdminController::class, 'updatebook'])->name('update-book');
		Route::get('/delete-book/{id}',[AdminController::class, 'deleteBook'])->name('delete-book');
		
		/****************************  Book functionality End  *************************************/	


		
});	
