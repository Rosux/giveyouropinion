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

Route::get('login', function() {
    return view('auth.login');
})->name('login');

Route::post('login', [AdminController::class, 'login']);

Route::get('register', function() {
    return view('auth.register');
})->name('register');

Route::post('register', [AdminController::class, 'register']);

Route::prefix('form')->group(function () {
    Route::get('/', [FormController::class, 'index']);

    Route::get('/create', function () {
        return view('form/create');
    });

    Route::post('/create', [FormController::class, 'create']);

    Route::get('/edit', function () {
        return view('form/edit');
    });

    Route::post('/edit', [FormController::class, 'edit']);

    Route::get('/show', function () {
        return view('form/create');
    });
});