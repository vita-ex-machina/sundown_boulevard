<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Booking\BookingController;

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
//     return view('home');
// });

// Route::get('/bookings',function(){
//     return view('bookings.index');
// });

Route::get('/',[HomeController::class, 'index'])->name('home');

Route::get('/bookings',[BookingController::class, 'index'])->name('bookings');
Route::post('/bookings', [BookingController::class, 'store']);

Route::get('/users', [UserController::class, 'index']);

//Route::resource('/bookings', BookingController::class);



// Route::get('/users', function () {
//     return view('users.index');
// });


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
