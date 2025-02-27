<?php

use App\Models\User;
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
    $products = DB::table('products')->get();
    return view('AdminSide.Auth.Login',compact('products'));
})->name('AdminLogin');

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

Route::get('/OrderHistory', function () {
    $UserOrders = DB::table('order_users')->get();
    return view('AdminSide.Pages.OrderPage',compact('UserOrders'));
})->name('OrderHistory');


Route::get('/UserInformationPage',function(){
    $users = DB::table('users')->where('userId',Auth::user()->userId)->get();
    return view('UserSide.Pages.UserInformationPage', compact('users'));
})->name('UserInformationPage');

//PurchaseHistory
Route::get('/CancelledPage',function () {
    return view('UserSide.Pages.PurchaseHistory.Cancelled'); 
})->name('CancelledPage');

Route::get('/ReceivedPage',function () {
    return view('UserSide.Pages.PurchaseHistory.Received'); 
})->name('ReceivedPage');

Route::get('/ToPayPage',function () {
    return view('UserSide.Pages.PurchaseHistory.ToPay'); 
})->name('ToPayPage');
//End of Purchase History Route

Route::get('/MainPage',function(){
    return view('UserSide.Layouts.MainPage');
})->name('MainPage');



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
Route::put('/updateProduct/{id}', [ProductController::class, 'updateProduct'])->name('update.product');
Route::delete('/archive/{id}', [ProductController::class, 'archiveEachProduct'])->name('archive.product');
Route::delete('/retore/{id}', [ProductController::class, 'RestoringSpecialProduct'])->name('restore.product');
Route::post('/addtocart/{id}',[UserController::class, 'UserAddToCart'])->name('addtocart');
Route::post('/removefromcart/{id}',[UserController::class, 'UserRemoveItemFromAddtoCart'])->name('removefromcart'); 
 Route::put('/UpdateInformationUser/{id}',[UserController::class,'UpdateInformationUser'])->name('UpdateInformationUser');
Route::post('/checkout/{id}', [UserController::class, 'checkout'])->name('checkout');