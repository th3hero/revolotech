<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Truck\BookingController;
use App\Http\Controllers\Truck\RegistrationController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [Controller::class, 'TruckListingData'])->name('listing.truck');
Route::post('add-truck', [RegistrationController::class, 'AddTruck'])->name('add.truck');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('book/{truck}', [BookingController::class, 'BookTruck'])->name('book.truck');
    Route::post('book', [BookingController::class, 'HandleBookRequestData'])->name('book');
    Route::get('bookings', [BookingController::class, 'BookingsByUser'])->name('bookings');
    Route::get('orders', [BookingController::class, 'BookingsOfOwner'])->name('orders');
});
