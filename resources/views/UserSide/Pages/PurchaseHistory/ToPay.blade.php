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

    .status-pending {
        color: #ffc107;
        font-weight: bold;
        padding: 2px 8px;
        border-radius: 4px;
        background-color: rgba(255, 193, 7, 0.1);
    }

    .cancel-form {
        margin-top: 15px;
    }

    .cancel-btn {
        width: 100%;
        padding: 10px;
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .cancel-btn:hover {
        background-color: #c82333;
    }

    @media (max-width: 768px) {
        .cards-container {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
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
        <h3>Hi, {{ Auth::user()->firstName }}! your pending orders.</h3>
        <h4>Total pending: {{ $toPayOrders->count() }}</h4>
        <div class="cards-container">
            @foreach ($toPayOrders as $order)
                <div class="order-card">
                    <div class="order-image">
                        <img src="{{ asset('images/' . $order->image) }}" alt="{{ $order->productName }}">
                    </div>
                    <div class="order-details">
                        <h3>{{ $order->productName }}</h3>
                        <div class="order-info">
                            <p><strong>Order ID:</strong> {{ $order->orderId }}</p>
                            <p><strong>Category:</strong> {{ $order->category }}</p>
                            <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
                            <p><strong>Price:</strong> ₱{{ number_format($order->price, 2) }}</p>
                            <p><strong>Total Amount:</strong> ₱{{ number_format($order->totalAmount, 2) }}</p>
                            <p><strong>Status:</strong> <span class="status-pending">{{ $order->orderStatus }}</span></p>
                            <p><strong>Address:</strong> {{ $order->address }}</p>
                            <p><strong>Order Date:</strong> {{ date('M d, Y h:i A', strtotime($order->created_at)) }}</p>
                        </div>
                        <form action="{{ route('cancel.order', $order->orderId) }}" method="post" class="cancel-form">
                            @csrf
                            <button type="submit" class="cancel-btn">Cancel Order</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
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
