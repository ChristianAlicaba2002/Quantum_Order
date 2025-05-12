<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSide\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/pending-orders-count', function () {
    $count = DB::table('orders')->where('orderStatus', 'Pending')->count();
    return response()->json(['count' => $count]);
});


