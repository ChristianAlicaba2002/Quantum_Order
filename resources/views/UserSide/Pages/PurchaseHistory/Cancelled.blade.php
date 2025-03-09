<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>{{ Auth::user()->firstName }} Cancelled History</title>
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

    <div class="container">
        @if (count($cancelledOrders) > 0)
            <table class="orders-table" id="TableCancelledOrders">
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
                    @foreach ($cancelledOrders as $order)
                        <tr>
                            <td>{{ $order->orderId }}</td>
                            <td>
                                <img src="{{ asset('/images/' . $order->image) }}" alt="{{ $order->productName }}"
                                    style="width:50px;">
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
    </script>

</body>

</html>
