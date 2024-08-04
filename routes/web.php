<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\DeliveryController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [TopController::class, 'index'])->name('top');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('/', [TopController::class, 'index'])->name('top');
Route::get('/delivery/{id}', [DeliveryController::class, 'show'])->name('delivery.show');
Route::post('/delivery/{id}/complete', [DeliveryController::class, 'complete'])->name('delivery.complete');
