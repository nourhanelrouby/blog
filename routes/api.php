<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\SettingController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('locale')->group(function () {

    // settings
    Route::prefix('settings')->controller(SettingController::class)->group(function () {
        Route::get('/', 'index');
        Route::put('/update', 'update');
    });

    // Categories
    Route::get('/categories/archive', [CategoryController::class, 'archive']);
    Route::put('/categories/restore/{id}', [CategoryController::class, 'restore']);
    Route::delete('/categories/delete/{category}', [CategoryController::class, 'delete']);
    Route::apiResource('categories', CategoryController::class);

    // Users
    Route::get('/users/archive', [UserController::class, 'archive']);
    Route::delete('/users/delete/{id}', [UserController::class, 'delete']);
    Route::put('/users/restore/{id}', [UserController::class, 'restore']);
    Route::apiResource('users', UserController::class);

    // Tags
    Route::apiResource('tags', TagController::class);

    // Posts
    Route::apiResource('posts', PostController::class);
});
