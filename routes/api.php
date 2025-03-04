<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class);
Route::post('user/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/me', function (Request $request) {
        return $request->user();
    });
});