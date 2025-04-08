<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('assets/logo.jpg')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/orderdetails.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Details</title>
</head>
<body>
    <div class="order-details">
        <h2>Order Details</h2>
    
        @if(session('error'))
            <div class="alert alert-danger">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
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
                <p><strong>Total Amount:</strong> <span class="price">₱{{ number_format($order->totalAmount, 2) }}</span></p>
                <p><strong>Payment:</strong> {{ $order->paymentMethod }}</p>
                <p><strong>Status:</strong> 
                    <span class="status-badge status-{{ strtolower($order->orderStatus) }}">
                        {{ $order->orderStatus }}
                    </span>
                </p>
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
                                <td class="price">₱{{ number_format($item->price, 2) }}</td>
                                <td class="price">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
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
                        <button type="submit" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Accept Order
                        </button>
                    </form>
    
                    <form action="{{ route('admin.update-order-status', ['orderId' => $order->orderId]) }}" method="POST" class="inline-form">
                        @csrf
                        <input type="hidden" name="status" value="Declined">
                        <button type="submit" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                            Decline Order
                        </button>
                    </form>
                </div>
            @endif
    
            <div class="back-button">
                <a href="{{ route('admin.pending-orders') }}" class="btn btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Back to Orders
                </a>
            </div>
        @else
            <div class="alert alert-danger">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                Order not found.
            </div>
        @endif
    </div>
</body>
</html>


