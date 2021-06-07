<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;

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

  
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('login', [UserController::class, 'login'])->name('login');

     
Route::middleware('auth:customerapi')->group( function () {

   Route::get('/userdetails',[UserController::class,'userdetails']);
   Route::get('/logout',[UserController::class,'logout']);
   Route::post('/change-password',[UserController::class,'restPassword']);
   Route::post('/update-profile',[UserController::class,'updateProfile']);
   Route::post('/update-address',[UserController::class,'updateAddress']);
   Route::get('/edit-user-details',[UserController::class,'edituserDetails']);

   Route::get('/cart-items',[ProductController::class,'cartListing']);
   Route::post('/add-to-cart',[ProductController::class,'addToCart']);
   Route::get('/remove-cart-item/{cartId}',[ProductController::class,'removeCartItem']);

   Route::get('/wish-list',[ProductController::class,'wishListing']);
   Route::post('/add-to-wish-list',[ProductController::class,'addToWishlist']);
   Route::get('/remove-wishlist/{id}',[ProductController::class,'removeWishItem']);

});

   Route::post('/forgot-password',[UserController::class,'forgotPassword']);
   Route::post('/verify-otp',[UserController::class,'verifyOTP']);
   Route::post('/update-password',[UserController::class,'updatePassword']);
   Route::get('/product-details/{productId}',[ProductController::class,'getProductDetails']);
   Route::get('/product-listing',[ProductController::class,'index']);
   Route::get('/category-listing',[ProductController::class,'categoryListing']);
