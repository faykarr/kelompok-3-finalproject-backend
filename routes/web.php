<?php


use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/testchat', function () {
    return view('chatbuilder');
});

Route::get('/open-api', [ChatController::class, 'index']);
Route::middleware('api')->post('/data', [ChatController::class, 'store']);
