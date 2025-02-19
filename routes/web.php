<?php

use App\Models\User;
use App\Models\Admin;
use App\Models\products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSide\UserController;
use App\Http\Controllers\AdminSide\AdminController;
use App\Http\Controllers\ProductSide\ExportToExcel;
use App\Http\Controllers\ProductSide\ProductController;
use App\Http\Controllers\ProductSide\ExportToPDFProducts;

// Public routes
Route::get('/', function () {
    $products = DB::table('products')->get();
    return view('UserSide.Auth.Login' , compact('products'));
})->name('login');

Route::get('/Register', function () {
    return view('UserSide.Auth.Register');
})->name('register');

// Admin login route (public)
Route::get('/AdminLogin', function () {
    return view('AdminSide.Auth.Login');
})->name('AdminLogin');

// // Protected admin routes

// Route::middleware('auth:admin')->group(function () {   
//     Route::get('/QuantumOrder', function () {
//         $users = DB::table('users')->get();
//         $products = products::all();
//         return view('AdminSide.Layouts.Dashboard', compact('users', 'products'));
//     })->name('QuantumOrder');

//     Route::get('/UserManagement', function () {
//         $users = User::all();
//         return view('AdminSide.Pages.UserManagement', compact('users'));
//     })->name('UserManagement');

//     Route::get('/Archive', function () {
//         $ArchiveProducts = DB::table('archive_products')->get();
//         return view('AdminSide.Pages.ArchiveProducts', compact('ArchiveProducts'));
//     })->name('ArchiveProducts');
// });

Route::get('/UserManagement', function () {
    $users = User::all();
    return view('AdminSide.Pages.UserManagement', compact('users'));
})->name('UserManagement');

Route::get('/Archive', function () {
    $ArchiveProducts = DB::table('archive_products')->get();
    return view('AdminSide.Pages.ArchiveProducts', compact('ArchiveProducts'));
})->name('ArchiveProducts');

// Export routes
Route::get('/products-pdf', [ExportToPDFProducts::class, 'exportPDF'])->name('products.pdf');
Route::get('/products.excel', [ExportToExcel::class, 'UserexportToExcel'])->name('products.excel');

// Authentication routes
Route::post('/auth/register', [UserController::class, 'UserRegister'])->name('auth.register');
Route::post('/auth/login', [UserController::class, 'UserLogin'])->name('auth.login');
Route::post('/auth/logout', [UserController::class, 'UserLogout'])->name('auth.logout');

Route::post('/auth/adminlogin', [AdminController::class, 'AdminLogin'])->name('auth.adminlogin');
Route::post('/auth/adminlogout', [AdminController::class, 'AdminLogout'])->name('auth.adminlogout');

// Product routes
Route::post('/product', [ProductController::class, 'addProduct'])->name('create.product');
Route::post('/archive/{id}', [ProductController::class, 'archiveEachProduct'])->name('archive.product');
Route::post('/retore/{id}', [ProductController::class, 'RestoringSpecialProduct'])->name('restore.product');
