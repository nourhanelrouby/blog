<?php

use App\Http\Controllers\CategoryController as ControllersCategoryController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\TagController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//     LOCALIZED ROUTES

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {

        //            Dashboard routes
        Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {

            Route::get('/home', function () {
                return view('dashboard.home');
            })->middleware(['auth', 'admin.check'])->name('home');

            //        Auth
            Route::controller(AuthController::class)->group(function () {
                Route::middleware('guest')->group(function () {
                    Route::get('login', 'login')->name('login');
                    Route::post('login', 'loginPost')->name('loginPost');
                });
                Route::middleware('auth')->group(function () {
                    Route::get('logout', 'logout')->name('logout');
                    Route::get('profile', 'profile')->name('profile');
                    Route::put('profileUpdate', 'profileUpdate')->name('profileUpdate');
                });
            });


            Route::middleware('auth')->group(function () {
                //        Settings
                Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
                    Route::controller(SettingController::class)->group(function () {
                        Route::get('/', 'index')->name('index');
                        Route::put('update', 'update')->name('update');
                    });
                });
                // For User CRUD
                Route::get('/users/archive', [UserController::class, 'archive'])->name('users.archive');
                Route::get('/users/ajax', [UserController::class, 'ajax'])->name('users.ajax');
                Route::get('/users/archiveAjax', [UserController::class, 'archiveAjax'])->name('users.archiveAjax');
                Route::put('/users/restore/{user}', [UserController::class, 'restore'])->name('users.restore');
                Route::delete('/users/delete/{user}', [UserController::class, 'delete'])->name('users.delete');
                Route::resource('users', UserController::class);

                // For Categories CRUD
                Route::get('/categories/archive', [CategoryController::class, 'archive'])->name('categories.archive');
                Route::get('/categories/ajax', [CategoryController::class, 'ajax'])->name('categories.ajax');
                Route::get('/categories/archiveAjax', [CategoryController::class, 'archiveAjax'])->name('categories.archiveAjax');
                Route::put('/categories/restore/{category}', [CategoryController::class, 'restore'])->name('categories.restore');
                Route::delete('/categories/delete/{category}', [CategoryController::class, 'delete'])->name('categories.delete');
                Route::resource('categories', CategoryController::class);

                // For Tags CRUD
                Route::get('tags/ajax', [TagController::class, 'ajax'])->name('tags.ajax');
                Route::resource('tags', TagController::class);

                // For Post CRUD
                Route::get('/posts/ajax',[PostController::class,'ajax'])->name('posts.ajax');
                Route::resource('posts',PostController::class);
            });
        });
    }
);
