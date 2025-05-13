<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>{{ Auth::user()->firstName }} Received History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }

        .back-link {
            color: orange;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        h1 {
            color: #333;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .orders-table img {
            width: 50%;
            height: 55%;
            border-radius: 50%;
        }

        .orders-table th,
        .orders-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .orders-table th {
            position: sticky;
            top: 0;
            background-color: #ff9100;
            color: white;
        }

        .orders-table tr:hover {
            background-color: #f9f9f9;
        }

        .status-accepted {
            color: #28a745;
            font-weight: bold;
        }

        .no-orders {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .Table-Container {
            max-width: 100%;
            max-height: 60vh;
            overflow-y: scroll;
        }

        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .order-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.2s;
        }

        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .order-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .order-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .order-details {
            padding: 15px;
        }

        .order-details h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 1.2rem;
        }

        .order-info p {
            margin: 5px 0;
            font-size: 0.9rem;
            color: #666;
        }

        .status-delivered {
            color: #28a745;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 4px;
            background-color: rgba(40, 167, 69, 0.1);
        }

        @media (max-width: 768px) {
            .cards-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
    </style>
</head>

<body>
    <div>
        <a href="{{ route('login') }}" class="back-link">Back to Home</a>
    </div>
    <h1>Received History</h1>
    <?php
    $UserOrders = DB::table('orders')
        ->where('userId', Auth::user()->userId)
        ->where('orderStatus', 'Delivered')
        ->get();
    ?>
    <h4>Orders: {{ $UserOrders->count() }}</h4>

    @if (count($receivedOrders) > 0)
        <div class="cards-container">
            @foreach ($receivedOrders as $order)
                <div class="order-card">
                    <div class="order-image">
                        <img src="{{ asset('/images/' . $order->image) }}" alt="{{ $order->productName }}">
                    </div>
                    <div class="order-details">
                        <h3>{{ $order->productName }}</h3>
                        <div class="order-info">
                            <p><strong>Order ID:</strong> {{ $order->orderId }}</p>
                            <p><strong>Product ID:</strong> {{ $order->productId }}</p>
                            <p><strong>Category:</strong> {{ $order->category }}</p>
                            <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
                            <p><strong>Price:</strong> ₱{{ number_format($order->price, 2) }}</p>
                            <p><strong>Status:</strong> <span class="status-delivered">{{ $order->orderStatus }}</span></p>
                            <p><strong>Order Date:</strong> {{ date('M d, Y', strtotime($order->created_at)) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-orders">
            <h3>No received orders found.</h3>
        </div>
    @endif
</body>

</html>
