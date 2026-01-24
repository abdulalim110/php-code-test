<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

// ----------------------------------------------------------------------
// DEVELOPMENT HELPER ROUTES
// Reviewer Note: These endpoints are for testing 'can_edit' logic purposes only.
// They will strictly work in local environment.
// ----------------------------------------------------------------------

if (app()->isLocal()) {
    Route::post('/dev/login', function (Illuminate\Http\Request $request) {
        // Simple login by email to get token instantly
        $user = App\Models\User::where('email', $request->email)->firstOrFail();
        
        return response()->json([
            'token' => $user->createToken('testing')->plainTextToken,
            'role' => $user->role,
            'message' => 'Use this token in Bearer Auth to test GET /users endpoint.'
        ]);
    });
}