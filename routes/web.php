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


Route::group(['account'],function(){

    //Guest routes
    Route::group(['middleware' => 'guest'],function(){
        Route::get('/account/register',[AccountController::class,'registration'])->name('account.register');
        Route::post('/account/process-register',[AccountController::class,'processRegistration'])->name('account.processRegistration');
        Route::get('/account/login',[AccountController::class,'login'])->name('account.login');
        Route::post('/account/authenticate',[AccountController::class,'authenticate'])->name('account.authenticate');

    });

    // Authenticated routes
    Route::group(['middleware' => 'auth'],function(){
        Route::get('/profile',[AccountController::class,'profile'])->name('account.profile');
        Route::put('/update-profile',[AccountController::class,'updateProfile'])->name('account.updateProfile');
        Route::get('/logout',[AccountController::class,'logout'])->name('account.logout');
        //still 24:17 part 4
    });
});


// Route::group(['middeleware' => 'auth'],function(){
//     Route::get('/',[AccountController::class,'index'])->name('home.index');
// });

