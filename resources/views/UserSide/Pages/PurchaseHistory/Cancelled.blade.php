<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>{{ Auth::user()->firstName }} Cancelled History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
            margin-bottom: 20px;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .orders-table th {
            position: sticky;
            top: 0;
            background-color: #ff9100;
            color: white;
        }

        .orders-table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            color: #666;
        }

        .orders-table td:nth-child(8) {
            color: #dc3545;
            font-weight: bold;
        }

        .orders-table th {
            text-align: center;
            background-color: #ff9100;
            color: white;
            padding: 11px;
            position: sticky;
            top: 0;
            max-width: 100%;
        }

        .orders-table tr:hover {
            background-color: #f9f9f9;
        }

        .no-orders {
            text-align: center;
            padding: 20px;
            color: #666;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .price-column {
            color: #666;
        }

        .container {
            max-width: 100%;
            max-height: 60vh;
            overflow-y: scroll;
        }

        .search-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #ff9100;
            box-shadow: 0 0 0 2px rgba(255, 145, 0, 0.1);
        }

        .cancelled-item {
            transition: all 0.3s ease;
        }

        .cancelled-item.hidden {
            display: none;
        }

        /* Add smooth transition for rows */
        .orders-table tr {
            transition: background-color 0.3s ease;
        }

        #noResults td {
            color: #666;
            background-color: #f9f9f9;
        }

        .reorder-btn {
            background: #FF6B35;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .reorder-btn:hover {
            background: #ff5722;
            transform: translateY(-2px);
        }

        .reorder-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        /* Alert styles */
        .alert-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 80%;
            max-width: 500px;
            text-align: center;
        }

        .alert-center {
            position: fixed;
            top: 15%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            animation: slideIn 0.5s ease-out;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert-icon {
            font-size: 20px;
        }

        .alert-close {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            padding: 5px;
            color: inherit;
            opacity: 0.7;
        }

        .alert-close:hover {
            opacity: 1;
        }

        @keyframes slideOut {
            from {
                transform: translateY(0);
                opacity: 1;
            }

            to {
                transform: translateY(-100%);
                opacity: 0;
            }
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

        .status-declined {
            color: #dc3545;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 4px;
            background-color: rgba(220, 53, 69, 0.1);
        }

        .reorder-form {
            margin-top: 15px;
        }

        .reorder-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .reorder-btn:hover {
            background-color: #0056b3;
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
    <h1>Cancelled History</h1>
    <?php
    $UserOrders = DB::table('orders')
        ->where('userId', Auth::user()->userId)
        ->where('orderStatus', 'Declined')
        ->get();
    ?>
    <h4>Cancelled: {{ $UserOrders->count() }}</h4>
    <input type="search" id="SearchItem" placeholder="Search cancelled orders..."
        oninput="searchCancelledItems(this.value)" class="search-input">

    <div class="alert-container">
        @if (session('success'))
            <div class="alert alert-success" id="successAlert">
                <i class="bi bi-check-circle alert-icon"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
    </div>

    <div class="alert-center">
        @if (session('error'))
            <div class="alert alert-danger" id="errorAlert">
                <i class="bi bi-exclamation-circle alert-icon"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <div class="container">
        @if (count($cancelledOrders) > 0)
            <div class="cards-container">
                @foreach ($cancelledOrders as $order)
                    <div class="order-card">
                        <div class="order-image">
                            <img src="{{ asset('/images/' . $order->image) }}" alt="{{ $order->productName }}">
                        </div>
                        <div class="order-details">
                            <h3>{{ $order->productName }}</h3>
                            <div class="order-info">
                                <p><strong>Order ID:</strong> {{ $order->orderId }}</p>
                                <p><strong>Category:</strong> {{ $order->category }}</p>
                                <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
                                <p><strong>Price:</strong> ₱{{ number_format($order->price, 2) }}</p>
                                <p><strong>Total Amount:</strong> ₱{{ number_format($order->totalAmount, 2) }}</p>
                                <p><strong>Status:</strong> <span class="status-declined">{{ $order->orderStatus }}</span></p>
                                <p><strong>Order Date:</strong> {{ date('M d, Y h:i A', strtotime($order->created_at)) }}</p>
                            </div>
                            <!-- <form action="/reorder-cancelled/{{$order->orderId}}" method="POST" class="reorder-form">
                                @csrf
                                <button type="submit" class="reorder-btn">
                                    Re-Attempt Order
                                </button>
                            </form> -->
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-orders">
                <h3>No cancelled orders found.</h3>
            </div>
        @endif
    </div>

    <script>
        function searchCancelledItems(searchText) {
            const table = document.getElementById('TableCancelledOrders');
            const rows = table.getElementsByTagName('tr');
            const searchTerm = searchText.toLowerCase().trim();

            // Start from index 1 to skip the header row
            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const orderId = row.cells[0].textContent.toLowerCase();
                const productName = row.cells[2].textContent.toLowerCase();
                const category = row.cells[3].textContent.toLowerCase();
                const price = row.cells[5].textContent.toLowerCase();
                const status = row.cells[7].textContent.toLowerCase();
                const date = row.cells[8].textContent.toLowerCase();

                const isMatch = orderId.includes(searchTerm) ||
                    productName.includes(searchTerm) ||
                    category.includes(searchTerm) ||
                    price.includes(searchTerm) ||
                    status.includes(searchTerm) ||
                    date.includes(searchTerm);

                if (isMatch) {
                    row.style.display = '';
                    // Highlight the matching row
                    row.style.backgroundColor = '#fff8f3';
                    setTimeout(() => {
                        row.style.backgroundColor = '';
                    }, 2000);
                } else {
                    row.style.display = 'none';
                }
            }

            // Show "No results" message if no matches found
            const visibleRows = Array.from(rows).slice(1).some(row => row.style.display !== 'none');
            const existingMessage = document.getElementById('noResults');

            if (!visibleRows) {
                if (!existingMessage) {
                    const noResults = document.createElement('tr');
                    noResults.id = 'noResults';
                    const messageCell = document.createElement('td');
                    messageCell.colSpan = '9'; // Span all columns
                    messageCell.style.textAlign = 'center';
                    messageCell.style.padding = '20px';
                    messageCell.innerHTML = `No cancelled orders found for "${searchText}"`;
                    noResults.appendChild(messageCell);
                    table.getElementsByTagName('tbody')[0].appendChild(noResults);
                }
            } else if (existingMessage) {
                existingMessage.remove();
            }
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.animation = 'slideOut 0.5s ease-out forwards';
                setTimeout(() => alert.remove(), 500);
            });
        }, 1500);
    </script>

</body>

</html>
