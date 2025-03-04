<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>Pending Orders</title>
</head>
<body>
    <a href="{{ route('AdminLogin') }}">Back to Dashboard</a>

<div class="pending-orders">
    <h2>Pending Orders</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="orders-table">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Image</th>
                    <th>Customer Name</th>
                    <th>Total Amount</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    $getOrders = DB::table('orders')->get();
                    $pendingOrders = $getOrders;
                ?>

                @if ($pendingOrders->count() > 0  )
                    @foreach($pendingOrders as $order)
                        <tr>
                            <td>{{ $order->orderId }}</td>
                            <td>{{ $order->firstName }}</td>
                            <td>₱{{ number_format($order->totalAmount, 2) }}</td>
                            <td>{{ date('M d, Y H:i', strtotime($order->created_at)) }}</td>
                            <td>
                                <a href="/order/{{$order->orderId}}" class="btn btn-info">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                 @else
                    <tr>
                        <td colspan="5" class="text-center">No pending orders found.</td>
                    </tr>
                @endif
                
               
            </tbody>
        </table>
    </div>
</div>
</body>
</html>