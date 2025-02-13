<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSide\UserController;


Route::get('/', function () {
    return view('UserSide.Auth.Register');
});


Route::post('/register',[UserController::class,'UserRegister'])->name('register');
