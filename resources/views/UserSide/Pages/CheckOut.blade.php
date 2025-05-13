<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout - Review Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .checkout-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .order-summary {
            margin-bottom: 30px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .items-table th {
            border-bottom: 2px solid orange;
            color: black;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .total-section {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
        }

        .shipping-info {
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .submit-btn {
            background-color: #ff9100;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            float: right;
        }

        .submit-btn:hover {
            background-color: #e68200;
        }

        .back-btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 10px;
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

        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
            padding: 20px;
            text-align: center;
        }

        .items-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .checkout-item {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fff;
        }

        .item-image {
            width: 60px;
            margin-right: 15px;
        }

        .item-image img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .item-details {
            flex: 1;
        }

        .item-details h3 {
            font-size: 14px;
            margin: 0 0 5px 0;
            color: #333;
        }

        .item-details p {
            font-size: 12px;
            margin: 2px 0;
            color: #666;
        }

        .total-section {
            margin-top: 15px;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 4px;
            text-align: right;
        }

        .total-section h3 {
            font-size: 16px;
            margin: 0;
            color: #333;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            margin-bottom: 3px;
            color: #555;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 13px;
        }

        .checkout-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: #FF6B35;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            margin-top: 15px;
        }

        .checkout-btn:hover {
            background: #ff5722;
        }

        .checkout-header {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 30px;
            padding: 20px;
        }

        .checkout-header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }

        .checkout-message {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #FF6B35;
            margin-bottom: 20px;
        }

        .checkout-message p {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="checkout-container">
        <div class="checkout-header">
            <h1>Review Your Order</h1>
            <div class="checkout-message">
                <p>Before completing your purchase, please review your items and payment details below. Make sure everything looks correct!</p>
                <p>Need to make changes? You can still update your cart or shipping information.</p>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @php
            $items = session('items', []);
            $totalPrice = session('totalPrice', 0);
        @endphp

        @if (!empty($items))
            <div class="items-container">
                @foreach ($items as $item)
                    <div class="checkout-item">
                        <div class="item-image">
                            <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['productName'] }}">
                        </div>
                        <div class="item-details">
                            <h3>{{ $item['productName'] }}</h3>
                            <p>Category: {{ $item['category'] }}</p>
                            <p>Qty: {{ $item['quantity'] }}</p>
                            <p>Price: ₱{{ number_format($item['price'], 2) }}</p>
                            <p>Subtotal: ₱{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                    </div>
                @endforeach

                <div class="total-section">
                    <h3>Total Amount: ₱{{ number_format($totalPrice, 2) }}</h3>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    @method("POST")
                    <input type="hidden" name="items" value="{{ json_encode($items) }}">
                    <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">
                    
                    <div class="form-group">
                        <label for="address">Delivery Address</label>
                        <input type="text" name="address" value="{{ Auth::user()->address }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phoneNumber">Contact Number</label>
                        <input type="text" name="phoneNumber" value="{{ Auth::user()->PhoneNumber }}" required>
                    </div>

                    <div class="form-group">
                        <label for="paymentMethod">Payment Method</label>
                        <input type="text" name="paymentMethod" value="Cash on Delivery" placeholder="Cash on Delivery" required readonly>
                    </div>

                    <button type="submit" class="checkout-btn">Place Order</button>
                </form>
            </div>
        @else
            <div class="no-items">
                <h2>No items selected for checkout</h2>
                <a href="{{ route('MainPage') }}" class="back-btn">Back to Shopping</a>
            </div>
        @endif
    </div>

    <script></script>
</body>

</html>