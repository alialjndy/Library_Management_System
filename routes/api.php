<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\BorrowRecordController;
use App\Http\Controllers\RatingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
//
Route::apiResource('borrow',BorrowRecordController::class )->middleware('auth:api');
Route::apiResource('user',UserController::class)->middleware('auth:api');
Route::apiResource('book', BookController::class)->middleware('auth:api');
Route::apiResource('rating', RatingController::class)->middleware('auth:api');

Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->middleware(AdminMiddleware::class);




Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout']);
// Route::get('me', [AuthController::class, 'getUser']);
