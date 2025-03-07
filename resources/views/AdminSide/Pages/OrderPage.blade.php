<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Management</title>
</head>
<body>
    <a href="{{ route('AdminLogin') }}">Back to Dashboard</a>
    <h1>Order Management</h1>

    <div>
        @if ($UserOrders->isEmpty())
            <p>No orders found.</p>
        @else
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Payment</th>
                <th>Category</th>
                <th>User Name</th>
                <th>User Phone</th>
                <th>User Address</th>
            </tr>
            <tbody>
                @foreach ($UserOrders as $order)
                    <tr>
                        <td>{{ $order->productId }}</td>
                        <td>{{$order->productName}}</td>
                        <td>{{$order->price}}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>{{ $order->payment }}</td>
                        <td>{{ $order->category }}</td>
                        <td>{{ $order->userNameLogin }}</td>
                        <td>{{ $order->userPhoneNumber}}</td>
                        <td>{{ $order->userAddress }}</td>                       
                    </tr>
                @endforeach
            </tbody>            
        @endif
    </div>
</body>
</html>