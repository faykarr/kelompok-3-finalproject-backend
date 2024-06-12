<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TestingController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// test api :
Route::get('/test',[ChatController::class, 'testapi']);
Route::post('/posttest',[ChatController::class, 'posttestapi']);

// chatbot
Route::post('/chat',[ChatController::class, 'responselocal']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/me', [UserController::class, 'me']);

    // Route::get('/admincek', [UserController::class, 'admin'])->middleware(RoleMiddleware::class);

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout']);
});