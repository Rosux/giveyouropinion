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
    return view('home');
});

// Register
Route::get('register', function() {
    return view('auth.auth', ["method" => "register"]);
})->name('register');

Route::post('register', [AdminController::class, 'register']);
//

// Login
Route::get('login', function() {
    return view('auth.auth', ["method" => "login"]);
})->name('login');

Route::post('login', [AdminController::class, 'login']);
//

Route::prefix('form')->group(function () {
    Route::get('/', [FormController::class, 'index']);

    Route::get('/create', [FormController::class, 'create']);

    Route::post('/store', [FormController::class, 'store']);

    Route::get('/show/{id}', [FormController::class, 'show']);

    Route::get('/edit/{id}', [FormController::class, 'edit']);

    Route::post('/update/{id}', [FormController::class, 'update']);

    Route::get('/delete/{id}', [FormController::class, 'destroy']);
});