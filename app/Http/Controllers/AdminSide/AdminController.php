<?php

namespace App\Http\Controllers\AdminSide;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function AdminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
    
        return back()->with('error', 'Account not found.');
    }
    
    public function AdminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerate();
        
        return redirect('/AdminLogin');
    }

    public function viewPendingOrders()
    {
        $pendingOrders = DB::table('orders')
            ->where('orderStatus', 'Pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('AdminSide.Pages.PendingOrders', compact('pendingOrders'));
    }

    public function viewOrderDetails($orderId)
    {
        try {
            // Get order information
            $order = DB::table('orders')
                ->where('orderId', $orderId)
                ->first();

            if (!$order) {
                return redirect()->route('admin.pending-orders')
                    ->with('error', 'Order not found');
            }

            // Get order details (products)
            $orderDetails = DB::table('order_details')
                ->where('orderId', $orderId)
                ->get();

            return view('AdminSide.Pages.OrderDetails', compact('order', 'orderDetails'));

        } catch (\Exception $e) {
            return redirect()->route('admin.pending-orders')
                ->with('error', 'Error loading order details: ' . $e->getMessage());
        }
    }

    public function updateOrderStatus(Request $request, $orderId)
    {
        try {
            // Validate request
            $request->validate([
                'status' => 'required|in:Accepted,Declined'
            ]);

            DB::beginTransaction();

            // Get the order
            $order = DB::table('orders')
                ->where('orderId', $orderId)
                ->first();

            if (!$order) {
                return redirect()->back()->with('error', "Don't have any order");
            }

            if ($request->status === 'Declined') {
                // If declining, return items to inventory
                $orderDetails = DB::table('order_details')
                    ->where('orderId', $orderId)
                    ->get();

                foreach ($orderDetails as $item) {
                    // Return quantity back to product stock
                    DB::table('products')
                        ->where('productId', $item->productId)
                        ->increment('stock', $item->quantity);
                }
            }

            // Update order status
            DB::table('orders')
                ->where('orderId', $orderId)
                ->update([
                    'orderStatus' => $request->status,
                    'updated_at' => now()
                ]);

            DB::commit();

            return redirect()->route('admin.pending-orders')
                ->with('success', 'Order has been ' . strtolower($request->status));

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating order: ' . $e->getMessage());
        }
    }

}
