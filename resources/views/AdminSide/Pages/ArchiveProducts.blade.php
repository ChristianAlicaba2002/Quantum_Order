<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/archive-products.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Archive Products</title>
</head>
<body>
    <div class="container">
        <a href="{{ route('AdminLogin') }}" class="back-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to Dashboard
        </a>

        <div class="page-header">
            <h1>Archived Products</h1>
            <p>These are all products you temporarily removed</p>
        </div>

        <div class="table-container">
            <table>
                <thead>
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
                </thead>
                <tbody>
                    @if (count($ArchiveProducts) == 0)
                        <tr>
                            <td colspan="9" class="no-products">No archive products found</td>
                        </tr>
                    @endif
                    @foreach ($ArchiveProducts as $ArchiveProduct)
                        <tr>
                            <td>{{ $ArchiveProduct->productId }}</td>
                            <td>
                                <img src="{{ asset('/images/' . $ArchiveProduct->image) }}" 
                                     alt="{{ $ArchiveProduct->productName }}"
                                     class="product-image">
                            </td>
                            <td>{{ $ArchiveProduct->productName }}</td>
                            <td>{{ $ArchiveProduct->category }}</td>
                            <td class="price">&#8369;{{ number_format($ArchiveProduct->price) }}</td>
                            <td>{{ $ArchiveProduct->stock }}</td>
                            <td>{{ $ArchiveProduct->description }}</td>
                            <td>{{ $ArchiveProduct->updated_at }}</td>
                            <td>
                                <div class="action-buttons">
                                    <form action="/retore/{{$ArchiveProduct->id}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="restore-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                                <polyline points="9 22 9 12 15 12 15 22"/>
                                            </svg>
                                            Restore
                                        </button>
                                    </form>
                                    <form action="" method="post">
                                        @csrf
                                        <button type="submit" class="delete-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="table-footer">
                <span>Total Archived Products: {{ count($ArchiveProducts) }}</span>
                <span>Last Updated: {{ now()->format('M d, Y H:i') }}</span>
            </div>
        </div>
    </div>
</body>
</html>