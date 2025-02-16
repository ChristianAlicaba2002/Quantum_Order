<?php

use App\Models\products;
use App\Models\RegisterUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSide\UserController;
use App\Http\Controllers\AdminSide\AdminController;
use App\Http\Controllers\ProductSide\ExportToExcel;
use App\Http\Controllers\ProductSide\ProductController;
use App\Http\Controllers\ProductSide\ExportToPDFProducts;



Route::get('/', function () {
    return view('UserSide.Auth.Login');
});

Route::get('/Register', function () {
    return view('UserSide.Auth.Register');
});

Route::get('/QuantumOrder', function () {
    $users = RegisterUser::all();
    $products = products::all();
    return view('AdminSide.Auth.Login', compact('users', 'products'));
})->name('QuantumOrder');

Route::get('/UserManagement', function () {
    $users = RegisterUser::all();
    return view('AdminSide.Pages.UserManagement', compact('users'));
})->name('UserManagement');

Route::get('/Archive',function(){
    $ArchiveProducts = DB::table('archive_products')->get();
    return view('AdminSide.Pages.ArchiveProductts',compact('ArchiveProducts'));
})->name('ArchiveProducts');


// Route::get('/ExportToPDF',function(){
//     $products = DB::table('products')->get();
//     return view('AdminSide.Pages.ExportToPDF',compact('products'));
// })->name('ExportToPDF');


Route::get('/products-pdf', [ExportToPDFProducts::class, 'exportPDF'])->name('products.pdf');
Route::get('/products.excel',[ExportToExcel::class,'UserexportToExcel'])->name('products.excel');



Route::post('/auth/register',[UserController::class, 'UserRegister'])->name('auth.register');
Route::post('/auth/login',[UserController::class, 'UserLogin'])->name('auth.login');
Route::post('/auth/logout',[UserController::class, 'UserLogout'])->name('auth.logout');


Route::post('/auth/adminlogin',[AdminController::class,'AdminLogin'])->name('auth.adminlogin');  
Route::post('/auth/adminlogout',[AdminController::class,'AdminLogout'])->name('auth.adminlogout');


Route::post('/product',[ProductController::class, 'addProduct'])->name('create.product');
Route::post('/archive/{id}',[ProductController::class, 'archiveEachProduct'])->name('archive.product');