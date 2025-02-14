<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSide\UserController;


Route::get('/', function () {
    return view('UserSide.Auth.Login');
});

Route::get('/Register', function () {
    return view('UserSide.Auth.Register');
});

Route::get('/MainPage', function () {
    return view('UserSide.Pages.MainPage');
})->name('MainPage');


Route::post('/auth/register',[UserController::class,'UserRegister'])->name('auth.register');
Route::post('/auth/login',[UserController::class,'UserLogin'])->name('auth.login');
Route::post('/auth/logout',[UserController::class,'UserLogout'])->name('auth.logout');