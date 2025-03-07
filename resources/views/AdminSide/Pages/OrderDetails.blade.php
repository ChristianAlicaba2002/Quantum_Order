<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Details</title>
</head>
<style>
    .order-details {
        padding: 20px;
    }
    
    .order-info {
        margin-bottom: 30px;
        background: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
    }
    
    .order-items table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }
    
    .order-items th,
    .order-items td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }
    
    .order-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn {
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-info {
        background-color: #17a2b8;
        color: white;
    }
    
    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
    }
    
    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
</style>
<body>
    
    <div class="order-details">
        <h2>Order Details</h2>
    
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    
        @if($order)
            <div class="order-info">
                <h3>Order Information</h3>
                <p><strong>Order ID:</strong> {{ $order->orderId }}</p>
                <p><strong>Customer Name:</strong> {{ $order->firstName }}</p>
                <p><strong>Address:</strong> {{ $order->address }}</p>
                <p><strong>Phone:</strong> {{ $order->phoneNumber }}</p>
                <p><strong>Total Amount:</strong> ₱{{ number_format($order->totalAmount, 2) }}</p>
                <p><strong>Payment:</strong> {{ $order->paymentMethod }}</p>
                <p><strong>Status:</strong> {{ $order->orderStatus }}</p>
                <p><strong>Order Date:</strong> {{ date('M d, Y H:i', strtotime($order->created_at)) }}</p>
            </div>
    
            <div class="order-items">
                <h3>Ordered Items</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orderDetails as $item)
                            <tr>
                                <td>{{ $item->productName }}</td>
                                <td>{{ $item->category }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₱{{ number_format($item->price, 2) }}</td>
                                <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No items found for this order.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
    
            @if($order->orderStatus === 'Pending')
                <div class="order-actions">
                    <form action="{{ route('admin.update-order-status', ['orderId' => $order->orderId]) }}" method="POST" class="inline-form">
                        @csrf
                        <input type="hidden" name="status" value="Accepted">
                        <button type="submit" class="btn btn-success">Accept Order</button>
                    </form>
    
                    <form action="{{ route('admin.update-order-status', ['orderId' => $order->orderId]) }}" method="POST" class="inline-form">
                        @csrf
                        <input type="hidden" name="status" value="Declined">
                        <button type="submit" class="btn btn-danger">Decline Order</button>
                    </form>
                </div>
            @endif
    
            <div class="back-button" style="margin-top: 20px;">
                <a href="{{ route('admin.pending-orders') }}" class="btn btn-secondary">Back to Orders</a>
            </div>
        @else
            <div class="alert alert-danger">
                Order not found.
            </div>
        @endif
    </div>
</body>
</html>


