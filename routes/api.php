<?php

use App\Http\Controllers\RecordPregnantController;
use App\Http\Controllers\RecordPtmController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('pregnants', RecordPregnantController::class);
Route::resource('ptm', RecordPtmController::class);
Route::resource('users', UserController::class);
Route::post('user/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/me', function (Request $request) {
        return $request->user();
    });
});