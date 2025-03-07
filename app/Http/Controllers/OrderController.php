<?php

namespace App\Http\Controllers;

use App\Models\OrderTracking;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show($orderId)
    {
        // Record visit when viewing order details
        OrderTracking::updateOrCreate(
            ['order_id' => $orderId],
            ['status' => 'visited']
        );

        // Your existing show method code...
    }

    public function acceptOrder($orderId)
    {
        OrderTracking::updateOrCreate(
            ['order_id' => $orderId],
            ['status' => 'accepted']
        );

        // Your existing accept order code...
    }

    public function declineOrder($orderId)
    {
        OrderTracking::updateOrCreate(
            ['order_id' => $orderId],
            ['status' => 'declined']
        );

        // Your existing decline order code...
    }
} 