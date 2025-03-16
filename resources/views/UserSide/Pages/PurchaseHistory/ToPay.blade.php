<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>{{ Auth::user()->firstName }} To Pay History</title>

</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f5f5f5;
    }

    .back-link {
        color: orange;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        margin-bottom: 24px;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    h1 {
        color: #333;
        font-size: 2rem;
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
        background-color: #ff9100;
        color: white;
    }

    .orders-table tr:hover {
        background-color: #f9f9f9;
    }

    .status-pending {
        color: #ff9100;
        font-weight: bold;
    }

    .no-orders {
        text-align: center;
        padding: 20px;
        color: #666;
        margin-top: 16%;
    }

    .no-orders h3 {
        font-size: 1.2rem;
    }

    .btn {
        background-color: #ff9100;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    h3,
    h4 {
        color: rgba(47, 47, 47, 0.651);
        font-size: 1rem;
    }

    .alertContainer {
        margin-top: -5rem;
        width: 100%;
        display: flex;
        justify-content: center;
        position: absolute;
    }

    .alert {
        border-radius: 8px;
        font-size: 0.9rem;
        border: none;
        position: absolute;
        width: 50%;
    }

    .alert p {
        text-align: center;
    }

    .alert-success {
        background: #def7ec;
        color: #03543f;
        text-align: center;
    }

    .alert-danger {
        background: #fde8e8;
        color: #9b1c1c;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.3s ease-in-out alternate;
    }
</style>

<body>
    <div>
        <a href="{{ route('login') }}" class="back-link">Back to Home</a>
    </div>
    <h1>To Pay History</h1>

    @if (session('success'))
        <div class="alertContainer">
            <div class="alert alert-success fade-in" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif


    @if (count($toPayOrders) > 0)
        <h3>Hi, {{ Auth::user()->firstName }}! Here are your pending orders.</h3>
        <h4>Total pending: {{ $toPayOrders->count() }}</h4>
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
                    <th>Address</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($toPayOrders as $order)
                    <tr>
                        <td>{{ $order->orderId }}</td>
                        <td>
                            <img src="{{ asset('images/' . $order->image) }}" alt="{{ $order->productName }}"
                                style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td> {{ $order->productName }}</td>
                        <td>{{ $order->category }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>₱{{ number_format($order->price, 2) }}</td>
                        <td>₱{{ number_format($order->totalAmount, 2) }}</td>
                        <td class="status-pending">{{ $order->orderStatus }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ date('M d, Y h:i A', strtotime($order->created_at)) }}</td>
                        <td>
                            <form action="{{ route('cancel.order', $order->orderId) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">Cancel</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-orders">
            <h3>No pending orders found.</h3>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {

                        alert.remove()
                    }, 300);
                }, 5000);
            });
        });
    </script>



</body>

</html>
