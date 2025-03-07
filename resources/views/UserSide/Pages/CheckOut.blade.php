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
    </style>
</head>

<body>
    <div class="checkout-container">
        <h1>Review Your Order</h1>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (isset($items) && !empty($items))
            <div class="order-summary">
                <h2>Order Summary</h2>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['productName'] }}"
                                        class="product-image">
                                    {{ $item['productName'] }}
                                </td>
                                <td>{{ $item['category'] }}</td>
                                <td>₱{{ number_format($item['price'], 2) }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>₱{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="total-section">
                    <strong>Total Amount: ₱{{ number_format($totalPrice, 2) }}</strong>
                </div>
            </div>

            <div class="shipping-info">
                <h2>Shipping Information</h2>

                <form action="{{ route('checkout.process') }}" method="post" id="checkoutForm">
                    @csrf
                    @foreach ($items as $index => $item)
                        <input type="hidden" name="items[{{ $index }}][productId]"
                            value="{{ $item['productId'] }}">
                        <input type="hidden" name="items[{{ $index }}][productName]"
                            value="{{ $item['productName'] }}">
                        <input type="hidden" name="items[{{ $index }}][category]"
                            value="{{ $item['category'] }}">
                        <input type="hidden" name="items[{{ $index }}][price]" value="{{ $item['price'] }}">
                        <input type="hidden" name="items[{{ $index }}][quantity]"
                            value="{{ $item['quantity'] }}">
                        <input type="hidden" name="items[{{ $index }}][image]" value="{{ $item['image'] }}">
                    @endforeach
                    <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">

                    <div class="form-group">
                        <label for="address">Delivery Address</label>
                        <input type="text" id="address" name="address" value="{{ Auth::user()->address }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="">Payment Method</label>
                        <input type="text" name="paymentMethod" value="Cash on Delivery" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="phoneNumber">Contact Number</label>
                        <input type="text" id="phoneNumber" name="phoneNumber" maxlength="11" minlength="11"
                            value="{{ Auth::user()->PhoneNumber }}" required>
                    </div>

                    <div style="margin-top: 30px;">
                        <a href="{{ url('/') }}" class="back-btn">Back</a>
                        <button type="submit" class="submit-btn">Place Order</button>
                    </div>
                </form>
            </div>
        @else
            <div class="alert alert-warning">
                <p>No items selected for checkout.</p>
                <a href="{{ url('/') }}" class="back-btn">Back to Shopping</a>
            </div>
        @endif
    </div>

    <script></script>
</body>

</html>
