<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SubAdminController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

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
    //this route is accessible without login
    Route::group(['middleware' => 'sub_admin.guest'],function(){
        Route::get('/register',[SubAdminController::class,'register'])->name('sub_admin.register');
        Route::post('/process',[SubAdminController::class,'process'])->name('sub_admin.process');
        Route::get('/login',[SubAdminController::class,'login'])->name('sub_admin.login');
        Route::post('/login-process',[SubAdminController::class,'attempt'])->name('sub_admin.authenticate');
    });

    Route::group(['middleware'=>'sub_admin.auth'],function(){
        Route::get('/dashboard',[SubAdminController::class,'dashboard'])->name('sub_admin.dashboard');
        Route::get('/logout',[SubAdminController::class,'logout'])->name('sub_admin.logout');
    });
});


Route::group(['prefix' => 'seller'],function(){
    //this route is accessible without login
    Route::group(['middleware' => 'seller.guest'],function(){
        Route::get('/register',[SellerController::class,'register'])->name('seller.register');
        Route::post('/process',[SellerController::class,'process'])->name('seller.process');
        Route::get('/login',[SellerController::class,'login'])->name('seller.login');
        Route::post('/login-process',[SellerController::class,'attempt'])->name('seller.authenticate');
    });

    Route::group(['middleware'=>'seller.auth'],function(){
        Route::get('/dashboard',[SellerController::class,'dashboard'])->name('seller.dashboard');
        Route::get('/logout',[SellerController::class,'logout'])->name('seller.logout');
    });
});


Route::group(['prefix' => 'user'],function(){
    //this route is accessible without login
    Route::group(['middleware' => 'user.guest'],function(){
        Route::get('/register',[UserController::class,'register'])->name('user.register');
        Route::post('/process',[UserController::class,'process'])->name('user.process');
        Route::get('/login',[UserController::class,'login'])->name('user.login');
        Route::post('/login-process',[UserController::class,'attempt'])->name('user.authenticate');
    });

    Route::group(['middleware'=>'user.auth'],function(){
        Route::get('/profile',[UserController::class,'profile'])->name('user.profile');
        Route::get('/logout',[UserController::class,'logout'])->name('user.logout');
    });
});

