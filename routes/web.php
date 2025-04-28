<?php

use App\Http\Controllers\AccountController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('/account/authenticate',[AccountController::class,'authenticate'])->name('account.authenticate');
Route::get('/profile',[AccountController::class,'profile'])->name('account.profile');
Route::get('/logout',[AccountController::class,'logout'])->name('account.logout');

Route::group(['account'],function(){

    Route::group(['middleware' => 'guest'],function(){
        Route::get('/account/register',[AccountController::class,'registration'])->name('account.register');
        Route::post('/account/process-register',[AccountController::class,'processRegistration'])->name('account.processRegistration');
        Route::get('/account/login',[AccountController::class,'login'])->name('account.login');

    });

    // Authenticated routes

    Route::group(['middleware' => 'guest'],function(){
        Route::get('/account/register',[AccountController::class,'registration'])->name('account.register');
        Route::post('/account/process-register',[AccountController::class,'processRegistration'])->name('account.processRegistration');
        Route::get('/account/login',[AccountController::class,'login'])->name('account.login');
        //still 24:17 part 4
    });
});
