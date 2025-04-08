<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('css/exporttopdf.css')}}">
    <title>Product List Report</title>
</head>

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