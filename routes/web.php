<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'app' => 'Binar Technical Test API',
        'version' => '1.0.0',
        'status' => 'running',
        'server_time' => now()->toIso8601String(),
        'maintainer' => 'Abdul Alim'
    ]);
});
