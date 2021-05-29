<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\ChangepasswordController;

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
   Route::post('/forgot-password',[UserController::class,'forgotPassword']);
   Route::post('/verify-otp',[UserController::class,'verifyOTP']);
   Route::post('/update-password',[UserController::class,'updatePassword']);
   Route::post('/update-profile',[UserController::class,'updateProfile']);
   Route::get('/edit-user-details',[UserController::class,'edituserDetails']);

});
