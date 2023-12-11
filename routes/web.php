<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubAdminController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'],function(){
    Route::group(['middleware' => 'admin.guest'],function(){
        Route::get('/login',[AdminController::class,'login'])->name('admin.login');
        Route::post('/login-process',[AdminController::class,'attempt'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'],function(){
        Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
        Route::get('/logout',[AdminController::class,'logout'])->name('admin.logout');
    });
});

Route::group(['prefix' => 'sub_admin'],function(){
    Route::group(['middleware' => 'sub_admin.guest'],function(){
        Route::get('/register',[SubAdminController::class,'register'])->name('sub_admin.register');
        Route::post('/process',[SubAdminController::class,'process'])->name('sub_admin.process');

    });
});
