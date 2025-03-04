<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>{{Auth::user()->firstName}} Cancelled History</title>
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
            margin-bottom: 20px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        .orders-table th, 
        .orders-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .orders-table th {
            background-color: #ff9100;
            color: white;
        }

        .orders-table tr:hover {
            background-color: #f9f9f9;
        }

        .status-declined {
            color: #dc3545;
            font-weight: bold;
        }

        .no-orders {
            text-align: center;
            padding: 20px;
            color: #666;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .price-column {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div>
        <a href="{{route('login')}}" class="back-link">Back to Home</a>
    </div>
    <h1>Cancelled History</h1>

    @if(count($cancelledOrders) > 0)
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cancelledOrders as $order)
                    <tr>
                        <td>{{ $order->orderId }}</td>
                        <td>
                            <img src="{{ asset('/images/' . $order->image) }}" alt="{{ $order->productName }}" style="width:50px;">
                        </td>
                        <td>{{ $order->productName }}</td>
                        <td>{{ $order->category }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td class="price-column">₱{{ number_format($order->price, 2) }}</td>
                        <td class="price-column">₱{{ number_format($order->totalAmount, 2) }}</td>
                        <td class="status-declined">{{ $order->orderStatus }}</td>
                        <td>{{ date('M d, Y h:i A', strtotime($order->created_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-orders">
            <h3>No cancelled orders found.</h3>
        </div>
    @endif
</body>
</html>