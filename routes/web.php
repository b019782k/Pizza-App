<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('storage', function () {
    Artisan::call('storage:link');
});
Route::get('clearcache', function () {
    Artisan::call('config:cache');
});



Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::post('add-to-cart', [HomeController::class, 'addToCart'])->name('addTocart');
Route::post('own_pizza', [HomeController::class, 'ownPizza'])->name('own_pizza');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

Route::get('place_order', [\App\Http\Controllers\OrderController::class,'placeOrder']);
Route::get('check_coupon_code', [\App\Http\Controllers\OrderController::class,'checkCouponCode']);
Route::post('make_payment', [\App\Http\Controllers\OrderController::class,'makePayment']);
Route::get('my_orders', [\App\Http\Controllers\OrderController::class,'myOrders']);

});

