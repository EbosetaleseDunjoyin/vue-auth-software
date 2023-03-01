<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VerificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Authenticate User
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);

Route::post('/auth/verify-password-token', [AuthController::class, 'verifyPasswordResetToken']);
Route::post('/send-sms-otp', [AuthController::class, 'sendOtp']);
Route::post('/send-email-otp', [AuthController::class, 'sendverification']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::get('/verify-otp/{otp}', [AuthController::class, 'verifyEmailOtp']);

//To Override Route login
Route::get('/loginissues', function (){
    return response()->json([
        'status' => false,
        'message' => 'unauthorized user',
        
    ], 400);
})->name('login');

Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->middleware('auth:sanctum');
Route::group(['middleware' => ['auth:sanctum','is_verified']], function() {
    Route::get('/auth/logout', [AuthController::class, 'logoutUser']);
    Route::get('/user/profile', [UserController::class , 'userProfile']);
    
    Route::get('/user/update-password', [AuthController::class, 'updatePassword']);
    Route::get('/user/update-email', [AuthController::class, 'updateEmail']);
    Route::get('/user/update-username', [AuthController::class, 'updateUsername']);
});


