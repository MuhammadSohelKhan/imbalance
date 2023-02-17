<?php

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

Auth::routes();

Route::middleware(['auth'])->group(function ()
{
	Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	Route::get('/summary/{summary}/lines', [App\Http\Controllers\HomeController::class, 'line'])->name('lines');
	Route::get('/line/{line}/operations', [App\Http\Controllers\HomeController::class, 'operation'])->name('operations');

	Route::get('change-password', [App\Http\Controllers\HomeController::class, 'getChangePasswordPage'])->name('password.get');
	Route::patch('change-password', [App\Http\Controllers\HomeController::class, 'postChangePassword'])->name('password.post');
});

