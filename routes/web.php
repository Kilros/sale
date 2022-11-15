<?php

use Illuminate\Support\Env;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ForgotPasswordController;
use GuzzleHttp\Middleware;
use Illuminate\Auth\Events\Login;
use Illuminate\Routing\Route as RoutingRoute;
use PHPUnit\TextUI\XmlConfiguration\Group;

use Gloudemans\Shoppingcart\Facades\Cart;
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

// Route::get('/', function () {
//     return view('home.index',[
//         "page" => "home"
//     ]);
//     // return env("APP_NAME");
// });

// Route::get('/dashboard', [LoginController::class, 'dashboard']); 
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/forget', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget');
Route::post('/forget', [ForgotPasswordController::class, 'submitForgetPasswordForm']);
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::post('/custom-login', [LoginController::class, 'customLogin'])->name('login.custom'); 
Route::get('/registration', [LoginController::class, 'registration'])->name('register-user');
Route::post('/custom-registration', [LoginController::class, 'customRegistration'])->name('register.custom'); 
Route::get('/signout', [LoginController::class, 'signOut'])->name('signout');


Route::prefix('admin')->middleware('verifylogin')->group(function (){
    Route::middleware(['verifylevel'])->group(function (){
        Route::get('/', [AdminController::class, 'index'])->name('admin');
        Route::get('/notify',[AdminController::class, 'notify'])->name('notify');
        Route::get('/user',[AdminController::class, 'user'])->name('user');
        Route::post('/user',[AdminController::class, 'user_actions']);
        // Route::post('/user/{id}',[AdminController::class, 'user'])->where('id', '[0-9]+');
        Route::get('/banner',[AdminController::class, 'banner'])->name('banner');
        Route::post('/banner',[AdminController::class, 'banner_actions']);
        Route::get('/category',[AdminController::class, 'category'])->name('category');
        Route::post('/category',[AdminController::class, 'category_actions']);
        Route::get('/category2',[AdminController::class, 'category2'])->name('category2');
        Route::post('/category2',[AdminController::class, 'category2_actions']);
        Route::get('/size',[AdminController::class, 'size'])->name('size');
        Route::post('/size',[AdminController::class, 'size_actions']);
        Route::get('/product',[AdminController::class, 'product'])->name('product');
        Route::post('/product',[AdminController::class, 'product_actions']);
    });   
    Route::get('/order',[AdminController::class, 'order'])->name('order');
    Route::post('/order',[AdminController::class, 'order_actions']);
    Route::get('/orderdetail/{id}',[AdminController::class, 'order_detail'])->where('id', '[0-9]+');
});
Route::prefix('/')->group(function (){
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::post('/get_products', [HomeController::class, 'get_products'])->name('get_products'); 
    Route::get('/order', [HomeController::class, 'order'])->name('order_custom');
    Route::post('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/{tag}', [HomeController::class, 'detail'])->where('tag', '[a-zA-z0-9-]+');
    // Route::get('/{category}', [HomeController::class, 'category'])->where('category', '[a-zA-z0-9-]+');
    Route::get('/{category}/{category2}', [HomeController::class, 'category2'])->where('category', '[a-zA-z0-9-]+')->where('category2', '[a-zA-z0-9-]+');
});
