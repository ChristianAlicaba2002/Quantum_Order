<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/sales.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Sales</title>
</head>

<body>


    <div class="sales-container">
        <a href="{{ route('AdminLogin') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
        <div class="sales-header">
            <h1>Product Sales & Inventory</h1>
            <p>Comprehensive overview of product sales and stock levels</p>
        </div>

        <div class="sales-table-container">
            <div class="table-header">
                <h2>Product Details</h2>
                <div class="table-actions">
                    <button class="export-btn">
                        <i class="bi bi-download"></i> Export
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="sales-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Current Stock</th>
                            <th>Sold</th>
                            <th>Earnings</th>
                            <th>Updated Stock</th>
                            <th>Sales Performance</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($sales) > 0)

                        @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->productId }}</td>
                            @if ($sale->stock == 0)
                            <td class="product-name"><del>{{ $sale->productName }}</del></td>
                            @else
                            <td class="product-name">{{ $sale->productName }}</td>

                            @endif
                            <td class="category">{{ $sale->category }}</td>
                            <td class="stock">
                                @if($sale->stock <= $sale->stock)
                                    <span class="stock-value">{{ $sale->stock }}</span>
                                    @endif
                            </td>
                            <td class="quantity">{{ $sale->total_quantity }}</td>
                            <td class="earnings">&#8369;{{ number_format($sale->total_quantity * $sale->price) }}.00</td>
                            <td class="update-stock-value">{{ $sale->stock }}</td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ ($sale->total_quantity / $sales->max('total_quantity')) * 100 }}%"></div>
                                </div>
                                <span class="progress-text">{{ $sale->total_quantity }} units</span>
                            </td>
                            <td>
                                @if ($sale->stock == 0)
                                    <span class="status-badge danger">Out of Stock</span>
                                @elseif ($sale->stock <= 10)
                                    <span class="status-badge normal">Low Stock</span>
                                @elseif ($sale->stock <= $sale->stock)
                                        <span class="status-badge success">Normal</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <td class="no-orders-found" colspan="10">
                            No Orders yet
                        </td>
                        @endif

                    </tbody>
                </table>
                <div class="table-footer">
                    <span>Total Sale Products: {{ count($sales) }}</span>
                    <span>Last Updated: {{ now()->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

</body>

</html>