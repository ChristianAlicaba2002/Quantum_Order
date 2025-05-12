<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('assets/logo.jpg')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/order-management.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Management</title>
</head>
<body>
    <div class="container">
        <a href="{{ route('AdminLogin') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to Dashboard
        </a>

        <h1 class="page-title">Order Management</h1>

        <div class="table-container">
            @if ($UserOrders->isEmpty())
                <div class="empty-state">
                    <p>No orders found.</p>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($UserOrders as $order)
                            <tr>
                                <td>{{ $order->orderId }}</td>
                                <td>
                                    <div class="customer-info">
                                        <strong>{{ $order->firstName }} {{ $order->lastName }}</strong>
                                        <div class="customer-details">
                                            <span>{{ $order->phoneNumber }}</span>
                                            <span>{{ $order->address }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="product-info">
                                        <img src="{{ asset('/images/' . $order->image) }}" alt="{{$order->productName}}" width="50" height="50" srcset="">
                                    </div>
                                </td>
                                <td>
                                    <div class="product-info">
                                        <strong>{{ $order->productName }}</strong>
                                        <span class="category">{{ $order->category }}</span>
                                    </div>
                                </td>
                                <td>{{ $order->quantity }}</td>
                                <td class="price">₱{{ number_format($order->price, 2) }}</td>
                                <td class="price">₱{{ number_format($order->totalAmount, 2) }}</td>
                                <td>{{ $order->paymentMethod }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($order->orderStatus) }}">
                                        {{ $order->orderStatus }}
                                    </span>
                                </td>
                                <td>{{ date('M d, Y H:i', strtotime($order->created_at)) }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.order-details', ['orderId' => $order->orderId]) }}" class="btn btn-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="16" x2="12" y2="12"></line>
                                                <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                            </svg>
                                            View
                                        </a>
                                        @if($order->orderStatus === 'Pending')
                                            <form action="{{ route('admin.update-order-status', ['orderId' => $order->orderId]) }}" method="POST" class="inline-form">
                                                @csrf
                                                <input type="hidden" name="status" value="Accepted">
                                                <button type="submit" class="btn btn-success">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="20 6 9 17 4 12"></polyline>
                                                    </svg>
                                                    Accept
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
                                                    Decline
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>