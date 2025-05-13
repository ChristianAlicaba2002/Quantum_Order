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
use App\Http\Middleware\PreventBackHistory;

// Client routes
Route::get('/', function () {
    if(Auth::guard('web')->check())
    {
        return redirect()->route('HomePage');
    }
    else
    {
        return view('UserSide.Auth.Login');
    }
})->name('login')->middleware(PreventBackHistory::class);


Route::get('/Register', function () {
    return view('UserSide.Auth.Register');
})->name('register');


// Admin login route (public)
Route::get('/AdminLogin', function () {
    if(Auth::guard('admin')->check())
    {
        return redirect()->route('dashboard');
    }
    else{
        return view('AdminSide.Auth.Login');
    }

})->name('AdminLogin')->middleware(PreventBackHistory::class);

//Client Side Middleware
Route::middleware(['auth:web'])->group( function (){
    
    Route::get('/HomePage',function(){
        return view('UserSide.Layouts.HomePage');
    })->name('HomePage');
    
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

    Route::get('/UserInformationPage',function(){
        $users = DB::table('users')->where('userId',Auth::user()->userId)->get();
        return view('UserSide.Pages.UserInformationPage', compact('users'));
    })->name('UserInformationPage');

    //PurchaseHistory
    Route::get('/cancelled-history', [UserController::class, 'cancelledHistory'])->name('user.cancelled-history');
    Route::get('/to-pay-history', [UserController::class, 'toPayHistory'])->name('user.to-pay-history');
    Route::get('/to-delivery', [UserController::class, 'DeliveryHIstory'])->name('user.to-delivery-history');
    Route::get('/received-history', [UserController::class, 'receivedHistory'])->name('user.received-history');
    Route::get('/checkout/preview', [UserController::class, 'checkoutPreview'])->name('checkout.preview');

    //End of Purchase History Route

});

//Admin Side Middleware
Route::middleware(['auth:admin'])->group( function () {
    
    Route::get('/dashboard', function(){
        $products = DB::table('products')->orderBy('created_at' , 'desc')->get();
        return view('AdminSide.Layouts.Dashboard', compact('products'));
    })->name('dashboard')->middleware(PreventBackHistory::class);

    Route::get('/UserManagement', function () {
        $users = User::all();
        return view('AdminSide.Pages.UserManagement', compact('users'));
    })->name('UserManagement');
    
    Route::get('/Archive', function () {
        $ArchiveProducts = DB::table('archive_products')->get();
        return view('AdminSide.Pages.ArchiveProducts', compact('ArchiveProducts'));
    })->name('ArchiveProducts');
    
    Route::get('/OrderHistory', function () {
        $UserOrders = DB::table('orders')
            ->join('users', 'orders.userId', '=', 'users.userId')
            ->join('order_details', 'orders.orderId', '=', 'order_details.orderId')
            ->join('products', 'order_details.productId', '=', 'products.productId')
            ->select(
                'orders.orderId',
                'orders.userId',
                'users.firstName',
                'users.lastName',
                'users.phoneNumber',
                'users.address',
                'orders.totalAmount',
                'orders.paymentMethod',
                'orders.orderStatus',
                'orders.created_at',
                'order_details.quantity',
                'order_details.image',
                'products.productName',
                'products.price',
                'products.category'
            )->orderBy('orders.created_at', 'desc')
            ->get();
        return view('AdminSide.Pages.OrderPage', compact('UserOrders'));
    })->name('OrderHistory');

});

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
Route::delete('/delete/{id}', [ProductController::class , 'DeleteEachProduct'])->name('delete.product');
Route::post('/addtocart/{id}',[UserController::class, 'UserAddToCart'])->name('addtocart');
Route::post('/removefromcart/{id}',[UserController::class, 'UserRemoveItemFromAddtoCart'])->name('removefromcart'); 
Route::put('/UpdateInformationUser/{id}',[UserController::class,'UpdateInformationUser'])->name('UpdateInformationUser');
Route::post('/checkout', [UserController::class, 'checkoutItems'])->name('checkout');

Route::get('/pending-orders', [AdminController::class, 'viewPendingOrders'])->name('admin.pending-orders');
Route::get('/order/{orderId}', [AdminController::class, 'viewOrderDetails'])->name('admin.order-details');
Route::post('/order/{orderId}/update-status', [AdminController::class, 'updateOrderStatus'])->name('admin.update-order-status');
Route::get('/sales', [AdminController::class , 'SalesProduct'])->name('admin.sales-product');

Route::post('/cancel.order/{orderId}', [UserController::class, 'cancelOrder'])->name('cancel.order');
Route::post('/reorder-cancelled/{orderId}', [UserController::class, 'reorderCancelled'])->name('reorder.cancelled');
Route::post('/checkout/process', [UserController::class, 'checkoutProcess'])->name('checkout.process');
Route::post('deliveredItems/{id}',[UserController::class , 'MoveToRecieved'])->name('deliveredItems.process');
Route::get('/order/receipt/{orderId}', [UserController::class, 'showOrderReceipt'])->name('user.order.receipt');
// Add this route for the order receipt