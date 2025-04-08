<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quantum Order</title>
</head>

<body>
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-content">
            <h1>Dashboard</h1>
            <p>Welcome to the admin Quantum Order dashboard</p>
        </div>
        <div class="header-actions">
            <button type="button" class="btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add Product
            </button>
            <form action="{{ route('auth.adminlogout') }}" method="post">
                @csrf
                <button type="submit" class="btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </header>

    <!-- Badges Attention -->
    <section>
        <nav class="MenuHamburger">
            @include('AdminSide.Pages.Badges')
            <ul>
                <!-- <li>
                    <a href="{{ route('ArchiveProducts') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="21 8 21 21 3 21 3 8"></polyline>
                            <rect x="1" y="3" width="22" height="5"></rect>
                            <line x1="10" y1="12" x2="14" y2="12"></line>
                        </svg>
                        Archive
                    </a>
                </li>
                <li>
                    <a href="{{ route('OrderHistory') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        Orders
                    </a>
                </li>
                <li>
                    <a href="/pending-orders" class="pending-orders-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Pending Orders
                        <span class="order-counter" id="orderCounter"></span>
                    </a>
                </li> -->

            </ul>
        </nav>
    </section>

    <!-- Alert Error -->
    <section>
        @if (session('failedToExport'))
        <div class="alert alert-danger">
            {{ session('failedToExport') }}
        </div>
        @endif
    </section>

    <!-- Container Badges -->
    <section>
        <div class="container downloads">
            <a href="{{ route('UserManagement') }}" class="export-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                User Management
            </a>

            <a href="{{ route('ArchiveProducts') }}" class="export-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                    <rect x="1" y="3" width="22" height="5"></rect>
                    <line x1="10" y1="12" x2="14" y2="12"></line>
                </svg>
                Archive
            </a>

            <a href="{{ route('OrderHistory') }}" class="export-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                Orders
            </a>

            <a href="/pending-orders" class="export-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                Pending Orders
                <span class="order-counter" id="orderCounter"></span>
            </a>

            <a href="{{ route('products.excel') }}" class="export-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                Export to Excel
            </a>
            <a href="{{ route('products.pdf') }}" class="export-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                Export to PDF
            </a>
        </div>

    </section>

    <!-- Category Navigation -->
    <section>
        @if (!$products->isEmpty())
        <nav class="category-nav-container">
            <ul class="category-nav">
                <li>
                    <button class="filter-btn active" onclick="filterProducts('all', event)">
                        All
                    </button>
                </li>
                @php
                $categories = $products->pluck('category')->unique();
                @endphp
                @foreach ($categories as $category)
                <li>
                    <button class="filter-btn" onclick="filterProducts('{{ $category }}', event)">
                        {{ $category }}'s
                    </button>
                </li>
                @endforeach
            </ul>
        </nav>
        @endif
    </section>

    <!-- Product Table -->
    <main>
        <div class="products-container">
            <h1 id="categoryTitle" class="section-title">All Products</h1>

            @if ($products->isEmpty())
            <p class="no-products">Don't have any products added</p>
            @else
            <div class="table-responsive">
                <table id="productTable" class="products-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products->sortBy('price') as $product)
                        <tr>
                            <td>{{ $product->productId }}</td>
                            <td>
                                <img class="product-image" src="{{ asset('/images/' . $product->image) }}" alt="{{ $product->productName }}">
                            </td>
                            <td>{{ $product->productName }}</td>
                            <td>{{ $product->category }}</td>
                            <td>&#8369;{{ number_format($product->price) }}</td>
                            <td class="{{ $product->stock <= 20 ? 'low-stock' : '' }}">{{ $product->stock }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->created_at }}</td>
                            <td class="action-cell">
                                <button class="edit-btn" type="button" onclick="EditProducts('{{ $product->productId}}','{{ $product->productName }}','{{ $product->category }}','{{ $product->price }}','{{ $product->stock }}','{{ $product->description }}','{{ $product->image }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    Edit
                                </button>
                                <form action="/archive/{{ $product->id }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="archive-btn" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                        Archive
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </main>

    <!-- Add Product Modal -->
    <section>
        <div id="addProductModal" class="modal">
            <div>
                <div>
                    <div>
                        <h5>Add New Product</h5>
                    </div>
                    <form action="{{ route('create.product') }}" method="POST" enctype="multipart/form-data">
                        <div>
                            @csrf
                            <div>
                                <label for="productName">Product Name</label>
                                <input type="text" id="productName" name="productName" required>
                            </div>
                            <div>
                                <label for="category">Category</label>
                                <input type="text" id="category" name="category" required>
                            </div>
                            <div>
                                <label for="price">Price</label>
                                <input type="number" id="price" name="price" step="0.01" required>
                            </div>
                            <div>
                                <label for="stock">Stock</label>
                                <input type="number" id="stock" name="stock" required>
                            </div>
                            <div>
                                <label for="description">Description</label>
                                <textarea id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div>
                                <label for="image">Product Image</label>
                                <input type="file" id="image" name="image" accept="image/*" required>
                                <img id="previewImage" src="" alt="No product image" class="previewImage">
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content:space-between;margin-top:1rem;">
                                <button type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit">Add Product</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>


    </section>

    <!-- Edit Product Modal -->
    <section>
        <div id="editProductModal" class="modal">
            <div>
                <div>
                    <div>
                        <h5>Edit Product</h5>
                    </div>
                    <form id="EditForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="EditProductId" name="productId">
                        <div>
                            <div>
                                <label for="EditProductName">Product Name</label>
                                <input type="text" id="EditProductName" name="productName" required>
                            </div>
                            <div>
                                <label for="EditCategory">Category</label>
                                <input type="text" id="EditCategory" name="category" required>
                            </div>
                            <div>
                                <label for="EditPrice">Price</label>
                                <input type="number" id="EditPrice" name="price" step="0.01" required>
                            </div>
                            <div>
                                <label for="EditStock">Stock</label>
                                <input type="number" id="EditStock" name="stock" required>
                            </div>
                            <div>
                                <label for="EditDescription">Description</label>
                                <textarea id="EditDescription" name="description" rows="3" required></textarea>
                            </div>
                            <div>
                                <label for="EditImage">Product Image</label>
                                <input type="file" id="EditImage" name="image" accept="image/*">
                                <img id="EditPreviewImage" src="" alt="" class="previewImage">
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content:space-between;margin-top:1rem;">
                                <button type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit">Save Changes</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Alert -->
    <section>
        @if (session('success'))
        <div class="toast success-toast">
            <div class="toast-content">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

    </section>

    <!-- Error Alert -->
    <section>
        @if (session('error'))
        <div class="toast error-toast">
            <div class="toast-content">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
        @endif
    </section>


    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{asset('js/dashboard.js')}}"></script>
</body>

</html>