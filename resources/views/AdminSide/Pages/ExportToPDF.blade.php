<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product List Report</title>
</head>
<style>
     body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            color: #333;
            direction: rtl;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .date {
            font-size: 12px;
            color: #666;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            direction: ltr;
            font-size: 9px;
            table-layout: fixed;
        }

        th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
            padding: 8px 4px;
            font-size: 10px;
            white-space: nowrap;
        }

        td {
            padding: 4px;
            font-size: 9px;
            word-wrap: break-word;
        }

        th,
        td {
            border: 1px solid #ddd;
            text-align: left;
            direction: ltr;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
            padding: 10px 0;
        }

        @page {
            size: landscape;
            margin: 15px;
        }
</style>
<body>
    <div class="header">
        <h1>Product List Report</h1>
        <div class="date">Generated on: {{ date('F d, Y') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->productId }}</td>
                    <td>{{ $product->productName }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ date('Y-m-d', strtotime($product->created_at)) }}</td>
                    <td>{{ date('Y-m-d', strtotime($product->updated_at)) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        © {{ date('Y') }} Quantum Order - Confidential products Report
    </div>
</body>
</html>