<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormController;

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
})->middleware('guest')->name('register');

Route::post('register', [UserController::class, 'register']);
//

// Login
Route::get('login', function() {
    return view('auth.auth', ["method" => "login"]);
})->middleware('guest')->name('login');

Route::post('login', [UserController::class, 'login']);

Route::get('logout', [UserController::class, 'logout'])->name('logout');

// http://127.0.0.1:8000/form/....
Route::prefix('form')->group(function () {
    // for admin views all forms -- anons get redirected to homepage
    Route::get('/', [FormController::class, 'index'])->middleware('auth'); 
    // admin's overview page (returns form.index)
    
    
    // where anons go to answer a question (page)
    Route::get('/{urlToken}', [FormController::class, 'getForm']); // anon's answer page (url token being the form 'urlToken' column)
    
    
    // where anons post their form data to (backend post)
    Route::post('/post', [FormController::class, 'postForm']); // anon's answer backend url
    

    // where admins go to create questions -- anons get redirected to homepage
    Route::post('/create', [FormController::class, 'createFormPost']); // creation backend url
    Route::get('/create', function(){return view('form.create');}); // creation page


    // where admins go to edit/close/change/open their forms
    Route::post('/edit', [FormController::class, 'editFormPost']); // edit backend url (form id is sent with POST request)
    Route::get('/edit/{id}', [FormController::class, 'editFormGet']); // edit page for specific form

});