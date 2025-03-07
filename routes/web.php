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
    return view('UserSide.Auth.Login');
})->name('login');

Route::get('/MainPage',function(){
    return view('UserSide.Layouts.MainPage');
})->name('MainPage');

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
Route::get('/cancelled-history', [UserController::class, 'cancelledHistory'])->name('user.cancelled-history');
Route::get('/to-pay-history', [UserController::class, 'toPayHistory'])->name('user.to-pay-history');
Route::get('/to-delivery', [UserController::class, 'DeliveryHIstory'])->name('user.to-delivery-history');
Route::get('/received-history', [UserController::class, 'receivedHistory'])->name('user.received-history');

//End of Purchase History Route

Route::get('/MainPage',function(){
    return view('UserSide.Layouts.MainPage');
})->name('MainPage');

Route::get('/ProductDetails/{productId}/{productName}/{category}/{price}/{stock}/{description}/{image}',function($productId,$productName,$category,$price,$stock,$description,$image){
    return view('UserSide.Pages.ProductDetails',
[
    'productId'=> $productId,
    'productName'=> $productName,
    'category'=> $category,
    'price'=> $price,
    'stock'=> $stock,
    'description'=> $description,
    'image'=> $image,
]);
})->name('ProductDetails');



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
Route::post('/checkout', [UserController::class, 'checkoutItems'])->name('checkout');

Route::get('/pending-orders', [AdminController::class, 'viewPendingOrders'])->name('admin.pending-orders');
Route::get('/order/{orderId}', [AdminController::class, 'viewOrderDetails'])->name('admin.order-details');
Route::post('/order/{orderId}/update-status', [AdminController::class, 'updateOrderStatus'])->name('admin.update-order-status');
Route::post('/cancel.order/{orderId}', [UserController::class, 'cancelOrder'])->name('cancel.order');


Route::post('/checkout/preview', [UserController::class, 'checkoutPreview'])->name('checkout.preview');
Route::post('/checkout/process', [UserController::class, 'checkoutProcess'])->name('checkout.process');
Route::post('deliveredItems/{id}',[UserController::class , 'MoveToRecieved'])->name('deliveredItems.process');
// Add this route for the order receipt
Route::get('/order/receipt/{orderId}', [UserController::class, 'showOrderReceipt'])->name('user.order.receipt');
