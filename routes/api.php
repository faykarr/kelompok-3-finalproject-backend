<?php

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\ProfileController;

// test api :
Route::get('/test',[ChatController::class, 'testapi']);
Route::post('/posttest',[ChatController::class, 'posttestapi']);

// chatbot
Route::post('/chat',[ChatController::class, 'responselocal']);


Route::get('/user', function (Request $request) {
    return new UserResource($request->user());
})->middleware('auth:api');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/me', [UserController::class, 'me']);

    Route::get('/admincek', [UserController::class, 'admin'])->middleware(RoleMiddleware::class);

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::post('/profile', [ProfileController::class, 'update']);
});

Route::prefix('list')->group(function () {
    route::get('/cities', [RegionController::class, 'city'])->name('city.list');
    route::get('/provinces', [RegionController::class, 'province'])->name('province.list');
});
