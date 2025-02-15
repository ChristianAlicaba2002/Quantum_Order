<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSide\UserController;
use App\Http\Controllers\AdminSide\AdminController;
use App\Models\RegisterUser;

Route::get('/', function () {
    return view('UserSide.Auth.Login');
});

Route::get('/Register', function () {
    return view('UserSide.Auth.Register');
});

Route::get('/QuantumOrder', function () {
    $users = RegisterUser::all();
    return view('AdminSide.Auth.Login', compact('users'));
})->name('QuantumOrder');


Route::post('/auth/register',[UserController::class,'UserRegister'])->name('auth.register');
Route::post('/auth/login',[UserController::class,'UserLogin'])->name('auth.login');
Route::post('/auth/logout',[UserController::class,'UserLogout'])->name('auth.logout');


Route::post('/auth/adminlogin',[AdminController::class,'AdminLogin'])->name('auth.adminlogin');  
Route::post('/auth/adminlogout',[AdminController::class,'AdminLogout'])->name('auth.adminlogout');