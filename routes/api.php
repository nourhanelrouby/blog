<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SettingController;
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
Route::prefix('settings')->middleware('locale')->controller(SettingController::class)->group(function () {
    Route::get('/', 'index');
    Route::put('/update', 'update');
});

// Categories
Route::get('/categories/archive', [CategoryController::class, 'archive']);
Route::put('/categories/restore/{id}', [CategoryController::class, 'restore']);
Route::delete('/categories/delete/{category}', [CategoryController::class, 'delete']);
Route::apiResource('categories', CategoryController::class);

