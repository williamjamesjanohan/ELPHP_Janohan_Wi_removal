<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::get('login', 'loginRedirected')->name('login');
    Route::post('login', 'login')->middleware('throttle:10,1'); // Rate limiting for login route
});

Route::get('recipes', [RecipeController::class, 'index'])->middleware('throttle:60,1'); // Public route for listing recipes with rate limiting

Route::middleware(['auth:sanctum', 'throttle:10,1'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('recipes', RecipeController::class)->except('index'); // Protect all other recipe routes
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
