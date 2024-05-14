<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\TestingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/chat',[ChatController::class, 'responselocal']);

Route::get('/hello', function () {
    return "Hello World!";
  });

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
