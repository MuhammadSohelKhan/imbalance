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
    return redirect()->route('login');
});

Auth::routes([
	'register'	=> FALSE,
	'reset'		=> FALSE,
	'verify'	=> FALSE,
]);

Route::middleware(['auth', 'verified'])->group(function ()
{
	Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	Route::get('client/{client_id}/projects', [App\Http\Controllers\HomeController::class, 'projects'])->name('projects');
	Route::get('/project/{project_id}/lines', [App\Http\Controllers\HomeController::class, 'lines'])->name('lines');
	Route::get('/archive-line/{line_id}', [App\Http\Controllers\LineController::class, 'archiveLine'])->name('archive_line');
	Route::get('/edit-line/{line_id}', \App\Http\Livewire\Line\EditLine::class)->name('edit_line');
	Route::get('/line/{line}/operations', [App\Http\Controllers\HomeController::class, 'operation'])->name('operations');
	//Route::get('/summary/{summary}/lines', [App\Http\Controllers\HomeController::class, 'line'])->name('lines');

	Route::get('summary-export/{projid}', [App\Http\Controllers\HomeController::class, 'exportSummary'])->name('summary.export');

	# PASSWORD ROUTES
	Route::get('change-password', [App\Http\Controllers\HomeController::class, 'getChangePasswordPage'])->name('password.get');
	Route::patch('change-password', [App\Http\Controllers\HomeController::class, 'postChangePassword'])->name('password.post');

	# USER ROUTES
	Route::get('add-user', [App\Http\Controllers\HomeController::class, 'getUserPage'])->name('user.get');
	Route::post('add-user', [App\Http\Controllers\HomeController::class, 'postUser'])->name('user.post');
	Route::post('delete-user/{user}', [App\Http\Controllers\HomeController::class, 'deleteUser'])->name('user.delete');
	Route::get('all-users', [App\Http\Controllers\HomeController::class, 'getAllUserPage'])->name('users.all');
});
