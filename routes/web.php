<?php

use App\Facade\Greeting;
use App\Facade\GreetingFacade;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SubAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPackageController;
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


Route::get('/custom-facade', function () {
    return response(GreetingFacade::greet(), 200);
 })->name('custom-facade');

Route::group(['prefix' => 'admin'],function(){
    Route::group(['middleware' => 'admin.guest'],function(){
        Route::get('/login',[AdminController::class,'login'])->name('admin.login');
        Route::post('/login-process',[AdminController::class,'attempt'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'],function(){
        Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
        Route::get('/logout',[AdminController::class,'logout'])->name('admin.logout');
        
        
        //permission user
        Route::get('/users', [PermissionController::class, 'index'])->name('admin.user');
        Route::get('/user-approved/{userId}', [PermissionController::class, 'approved'])->name('customer.approved');
        Route::get('/user-disapprove/{userId}', [PermissionController::class, 'disApprove'])->name('customer.disapproved');
        //permission sub admin
        Route::get('/sub-admins',[PermissionController::class,'subAdmin'])->name('admin.sub_admin');
        Route::get('/sub-approved/{subAdminId}', [PermissionController::class, 'approvedSubAdmin'])->name('sub_admin.approved');
        Route::get('/sub-disapprove/{subAdminId}', [PermissionController::class, 'disApproveSubAdmin'])->name('sub_admin.disapproved');
       //approve seller
        Route::get('/sellers',[PermissionController::class,'seller'])->name('admin.seller');
        Route::get('/seller-approved/{sellerId}', [PermissionController::class, 'approvedSeller'])->name('seller.approved');
        Route::get('/seller-disapprove/{sellerId}', [PermissionController::class, 'disApproveSeller'])->name('seller.disapproved');
        //permission seller
        Route::get('/seller-permissions/{seller}',[PermissionController::class,'create'])->name('seller.permission');
        Route::post('/seller-permissions/{seller}',[PermissionController::class,'store'])->name('permission.store');


        //category
        Route::resource('categories',CategoryController::class);

        //product
        Route::resource('products',ProductController::class);

        //review
        Route::get('/reviews',[ReviewController::class,'index'])->name('admin.reviews');
        Route::get('/admin-review/{productId}',[ReviewController::class,'createAdmin'])->name('admin.give_review');
        Route::post('/admin',[ReviewController::class,'store'])->name('admin.review.process');
        Route::get('/admin-approved/{reviewId}',[ReviewController::class,'approve'])->name('review.approved');
        Route::get('/admin-disapproved/{reviewId}',[ReviewController::class,'disApprove'])->name('review.disapproved');
        
        //package
        Route::resource('packages',PackageController::class);



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

        
        Route::get('/products',[ProductController::class,'subAdminIndex'])->name('sub_admin.products.index');
        Route::get('/products/create',[ProductController::class,'subAdminCreate'])->name('sub_admin.products.create');
        Route::post('/products',[ProductController::class,'store'])->name('sub_admin.products.store');
        Route::get('/products/{product}/edit',[ProductController::class,'subAdminEdit'])->name('sub_admin.products.edit');
        Route::put('/products/{product}',[ProductController::class,'update'])->name('sub_admin.products.update');
        Route::delete('/products/delete/{product}',[ProductController::class,'subAdminDestroy'])->name('sub_admin.products.destroy');

        //review 
        Route::get('/subadmin-review/{productId}',[ReviewController::class,'createSubadmin'])->name('sub_admin.give_review');
        Route::post('/subadmin',[ReviewController::class,'store'])->name('sub_admin.review.process');



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

        //product
        Route::get('/products',[ProductController::class,'sellerIndex'])->name('seller.products.index');
        Route::get('/products/create',[ProductController::class,'sellerCreate'])->name('seller.products.create');
        Route::post('/products',[ProductController::class,'store'])->name('seller.products.store');
        //
        Route::middleware('product.owner')->group(function(){
            Route::get('/products/{product}/edit',[ProductController::class,'sellerEdit'])->name('seller.products.edit');
        });
        Route::put('/products/{product}',[ProductController::class,'update'])->name('seller.products.update');
        Route::delete('/products/delete/{product}',[ProductController::class,'sellerDestroy'])->name('seller.products.destroy');

           //review 
        Route::get('/seller-review/{productId}',[ReviewController::class,'createSeller'])->name('seller.give_review');
        Route::post('/seller',[ReviewController::class,'store'])->name('seller.review.process');


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
        Route::get('/logout',[UserController::class,'logout'])->name('user.logout');

        Route::middleware('is_subscribe')->group(function(){
            Route::get('/profile',[UserController::class,'profile'])->name('user.profile');//1
        });

        //user-subscribe
        Route::middleware('show_package')->group(function(){
            Route::get('/package',[UserPackageController::class,'index'])->name('user.package');//2
        });
        //checkout user-subscribe
        Route::get('/checkout/{packageId}',[UserPackageController::class,'createPackage'])->name('user.buy');//3
        Route::get('/success',[UserPackageController::class,'storePackage'])->name('checkout.success');//4
        Route::get('/cancel',[UserPackageController::class,'cancelPackage'])->name('checkout.cancel');//5


        //cart
        Route::get('/cart',[CartController::class,'index'])->name('user.cart');
        Route::post('/add-cart/{product}',[CartController::class,'create'])->name('user.addToCart');
        Route::put('/update-cart/{product}',[CartController::class,'update'])->name('user.updateItem');
        Route::delete('/delete-cart/{product}',[CartController::class,'destroy'])->name('user.deleteItem');

        //order stripe
        Route::get('/checkout-order',[CartController::class,'createOrder'])->name('cart.checkout');
        Route::get('/store-checkout', [CartController::class, 'storeOrder'])->name('order.pay');
        Route::get('/cart-cancel', [CartController::class, 'cancelOrder'])->name('order.cancel');

        //orders
        Route::get('/product-order',[CartController::class,'order'])->name('user.order');
        Route::get('/product/{orderId}',[CartController::class,'show'])->name('order.product');
        
        //single product
        Route::get('/single-product/{productId}',[UserController::class,'show'])->name('product');
        //review
        Route::get('/review-create/{productId}',[ReviewController::class,'create'])->name('review');
        Route::post('/review-create',[ReviewController::class,'store'])->name('review.process');



        



    });
});
