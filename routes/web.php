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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false
]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('listing/truck', [Controller::class, 'TruckListingData'])->name('listing.truck');
Route::post('add-truck', [RegistrationController::class, 'AddTruck'])->name('add.truck');
Route::get('book/{truck}', [BookingController::class, 'BookTruck'])->name('book.truck');
