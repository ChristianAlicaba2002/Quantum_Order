<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Archive Products</title>
</head>
<body>
    
    <a href="{{ route('AdminLogin') }}">Back to Dashboard</a>
    <h1>Archive Products</h1>
    <p>These are all products you temporary remove</p>
    <table>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Description</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
            @if (count($ArchiveProducts) == 0)
                <tr>
                    <td colspan="9">No archive products found</td>
                </tr>
            @endif
            @foreach ($ArchiveProducts as $ArchiveProduct)
                <tr>
                    <td>{{ $ArchiveProduct->productId }}</td>
                    <td>
                        <img src="{{ asset('/images/' . $ArchiveProduct->image) }}" alt="{{ $ArchiveProduct->productName }}"
                            style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td>{{ $ArchiveProduct->productName }}</td>
                    <td>{{ $ArchiveProduct->category }}</td>
                    <td>&#8369;{{ number_format($ArchiveProduct->price) }}</td>
                    <td>{{ $ArchiveProduct->stock }}</td>
                    <td>{{ $ArchiveProduct->description }}</td>
                    <td>{{ $ArchiveProduct->updated_at}}</td>
                    <td>
                        <form action="/retore/{{$ArchiveProduct->id}}" method="post">
                            @csrf
                            <button type="submit">Restore</button>
                        </form>
                        <form action="" method="post">
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
</body>
</html>