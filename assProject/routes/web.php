<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SellerPortalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    // return view('welcome');
    return redirect('home');
});
Route::get('/home', [HomeController::class, 'index']);
Route::get('car', [CarController::class, 'showAllCar']);
Route::get('car/{honda}', [CarController::class, 'showCar']);
Route::get('car/{perodua}', [CarController::class, 'showCar']);
Route::get('car/{proton}', [CarController::class, 'showCar']);


// user authentication
Route::group(['middleware' => 'auth'], function () {
    Route::get('car/proton/{id}', [CarController::class, 'showDetailCar']);
    Route::get('car/perodua/{id}', [CarController::class, 'showDetailCar']);
    Route::get('car/honda/{id}', [CarController::class, 'showDetailCar']);

    Route::get('car/{brand}/{id}/contact', [MessageController::class, 'showContactForm']);
    Route::post("contactMessage", [MessageController::class, 'contactMessage']);
    // Get user info using user id
    Route::get('profile/{id}', [UserController::class, 'showDetailUser']);
    // Update user role to seller
    Route::get('changeRole/{id}', [UserController::class, 'changeRoleToSeller']);
    // Get message using car id
    Route::get('message/{id}', [MessageController::class, 'showMessage']);
    Route::get('/seller/dashboard', [SellerPortalController::class, 'showListings'])->name('seller.dashboard');
    Route::delete('/seller/car/{car}', [SellerPortalController::class, 'destroy'])->name('seller.destroy');
    // Show the create car form
    Route::get('/create', [SellerPortalController::class, 'create'])->name('seller.create');

    // Save the created car
    Route::post('/seller/cars', [SellerPortalController::class, 'store'])->name('seller.store');
    Route::post('/seller/update/{id}', [SellerPortalController::class, 'update'])->name('seller.update');
    Route::post('/seller/edit/{id}', [SellerPortalController::class, 'edit'])->name('seller.edit');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('logout', [LoginController::class, 'logout']);
