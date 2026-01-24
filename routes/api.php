<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
