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


// Login
Route::get('login', function() {
    return view('auth.auth', ["method" => "login"]);
})->middleware('guest')->name('login');

Route::post('login', [UserController::class, 'login']);


Route::get('logout', [UserController::class, 'logout'])->name('logout');

// http://127.0.0.1:8000/form/....
Route::prefix('form')->group(function () {
    // for admin views all forms -- anons get redirected to homepage
    // admin's overview page (returns form.index)
    Route::get('/', [FormController::class, 'index'])->middleware('auth');


    // answers (anons get redirected) users/admins can see answers to specific forms
    Route::get('/answers', function(){return redirect('/form');})->middleware('auth');
    Route::get('/answers/{urlToken}', [FormController::class, 'answersIndex'])->middleware('auth');
    

    // where anons post their form data to (backend post)
    Route::post('/post', [FormController::class, 'postForm']); // anon's answer backend url
    

    // where admins go to create questions -- anons get redirected to homepage
    Route::post('/create', [FormController::class, 'createFormPost'])->middleware('auth'); // creation backend url
    Route::get('/create', function(){return view('form.create');})->middleware('auth'); // creation page
    
    // where admins/users go to delete their forms
    Route::post('/delete', [FormController::class, 'deleteFormPost'])->middleware('auth');
    
    // where admins go to edit/close/change/open their forms
    Route::post('/edit', [FormController::class, 'editFormPost'])->middleware('auth'); // edit backend url (form id is sent with POST request)
    Route::get('/edit/{id}', [FormController::class, 'editFormGet'])->middleware('auth'); // edit page for specific form
    
    ////////////////////// SUPER BELANGERIJK: DEZE ROUTE ONDERAAN HOUDEN ANDERS VERPEST HET ALLE ANDERE ROUTES /////////////////////////
    // where anons go to answer a question (page) (for admins/users it shows the form answers)
    Route::get('/{urlToken}/{password?}', [FormController::class, 'getForm']); // anon's answer page (url token being the form 'urlToken' column)
});