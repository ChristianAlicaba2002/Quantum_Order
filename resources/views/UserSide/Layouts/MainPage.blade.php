<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>Quantum Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: #ffffff;
        font-family: Arial, sans-serif;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 2rem;
        background-color: white;
    }

    .logo {
        color: #FF6B35;
        font-weight: bold;
        font-size: 1.5rem;
    }

    .search-bar {
        flex-grow: 1;
        max-width: 600px;
        margin: 0 2rem;
    }

    .search-bar input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f5f5f5;
    }

    nav ul {
        display: flex;
        gap: 20px;
        list-style: none;
        padding: 10px 20px;
        margin: 0;
        border-bottom: 1px solid #eee;
        background-color: #ffffff;
    }

    nav button {
        color: #666;
        padding: 8px 16px;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 14px;
    }

    nav button.active {
        color: #FF6B35;
        background: none;
    }

    .products {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px;
    }

    .product-card {
        flex: 0 0 calc(25% - 15px);
        /* 25% width for 4 items per row, minus gap */
        background: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .product-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transform: translateY(-4px);
    }

    .image-container {
        position: relative;
        width: 100%;
        background: #D3D3D3;
        aspect-ratio: 4/3;
        overflow: hidden;
        border-radius: 8px 8px 0 0;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .image-container img {
        transform: scale(1.05);
    }

    .view-more {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #666;
        background: rgba(255, 255, 255, 0.9);
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 14px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .view-more {
        opacity: 1;
    }

    .product-info {
        padding: 15px;
        background: #f9f9f9;
        border-radius: 0 0 8px 8px;
    }

    .product-details {
        margin-bottom: 8px;
    }

    .price-cart-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price {
        color: #FF0000;
        font-size: 14px;
        font-weight: normal;
        margin: 0;
        /* Remove margin bottom */
    }

    .add-to-cart {
        background-color: #FF6B35;
        color: white;
        border: none;
        padding: 10px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        transition: background-color 0.3s ease;
        width: auto;
        min-width: 90px;
    }

    .add-to-cart:hover {
        background-color: #ff5722;
    }

    .add-to-cart-btn {
        background: #FF6B35;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        float: right;
        transition: background-color 0.3s ease;
    }

    .add-to-cart-btn:hover {
        background: #ff5722;
    }

    .category-title {
        font-size: 24px;
        padding: 20px;
        color: #333;
    }

    .products>div {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .product-card.fade-out {
        opacity: 0;
        transform: translateY(10px);
    }

    .product-card.fade-in {
        opacity: 1;
        transform: translateY(0);
    }

    /* Skeleton Loading Styles */
    .skeleton {
        background: #f0f0f0;
        background: linear-gradient(110deg, #ececec 8%, #f5f5f5 18%, #ececec 33%);
        background-size: 200% 100%;
        animation: 1.5s shine linear infinite;
    }

    @keyframes shine {
        to {
            background-position-x: -200%;
        }
    }

    .skeleton-card {
        flex: 0 0 calc(25% - 15px);
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    .skeleton-image {
        width: 100%;
        aspect-ratio: 4/3;
    }

    .skeleton-info {
        padding: 15px;
    }

    .skeleton-text {
        height: 12px;
        margin-bottom: 8px;
        border-radius: 4px;
    }

    .skeleton-text.title {
        width: 80%;
        height: 14px;
    }

    .skeleton-text.category {
        width: 60%;
    }

    .skeleton-text.price {
        width: 40%;
    }

    .skeleton-button {
        width: 100%;
        height: 32px;
        border-radius: 4px;
        margin-top: 12px;
    }

    /* Hide skeleton cards when not loading */
    .products:not(.loading) .skeleton-card {
        display: none;
    }

    /* Show product cards when not loading */
    .products:not(.loading) .product-card {
        display: block;
    }

    /* Hide product cards while loading */
    .products.loading .product-card {
        display: none;
    }

    #skeletonContainer {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        width: 100%;
    }

    #productsList {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        width: 100%;
    }

    .alertContainer {
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .alert {
        border-radius: 8px;
        font-size: 0.9rem;
        border: none;
        position: absolute;
        width: 50%;
    }

    .alert p {
        text-align: center;
    }

    .alert-success {
        background: #def7ec;
        color: #03543f;
    }

    .alert-danger {
        background: #fde8e8;
        color: #9b1c1c;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.3s ease-in-out alternate;
    }
</style>

<body>
    @include('UserSide.Pages.HeaderPage')
    <nav>
        <ul>
            <li><button onclick="filterProducts('All', event)">All</button></li>
            @php
                $categories = DB::table('products')->pluck('category')->unique();
            @endphp
            @foreach ($categories as $category)
                <li><button onclick="filterProducts('{{ $category }}', event)">{{ $category }}</button></li>
            @endforeach
        </ul>
    </nav>

    <div>

        @if (session('success'))
            <div class="alertContainer">
                <div class="alert alert-success fade-in" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif


        @if (session('error'))
            <script>
                alert("{{ session('error') }}")
            </script>
        @endif

        <div>
            <h2 class="category-title" id="categoryName">All</h2>
        </div>

        <div class="products loading" id="productsContainer">
            <!-- Skeleton Loading Template -->
            <div id="skeletonContainer">
                @for ($i = 0; $i < 10; $i++)
                    <div class="skeleton-card">
                        <div class="skeleton-image skeleton"></div>
                        <div class="skeleton-info">
                            <div class="skeleton-text title skeleton"></div>
                            <div class="skeleton-text category skeleton"></div>
                            <div class="skeleton-text price skeleton"></div>
                            <div class="skeleton-button skeleton"></div>
                        </div>
                    </div>
                @endfor
            </div>

            <?php
            $products = DB::table('products')->get();
            ?>

            <!-- Actual Products -->
            <div id="productsList">
                @if ($products->isEmpty())
                    <h3>No available products</h3>
                @else
                    @foreach ($products->sortBy('price') as $product)
                        <div class="product-card">
                            <div class="image-container">
                                <img src="{{ asset('/images/' . $product->image) }}" alt="{{ $product->productName }}"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/default-product.png') }}'">
                                <a href="/ProductDetails/{{ $product->productId }}/{{ $product->productName }}/{{ $product->category }}/{{ $product->price }}/{{ $product->stock }}/{{ $product->description }}/{{ $product->image }}"
                                    class="view-more">View more</a>
                            </div>
                            <div class="product-info">
                                <div class="product-details">
                                    <h3 class="product-name">{{ $product->productName }}</h3>
                                    <p class="product-category">{{ $product->category }}</p>
                                </div>
                                <div class="price-cart-container">
                                    <p class="price">&#8369;{{ number_format($product->price, 2) }}</p>
                                    <form action="{{ route('addtocart', ['id' => $product->productId]) }}"
                                        method="POST" style="margin: 0;">
                                        @csrf
                                        <input type="hidden" name="productId" value="{{ $product->productId }}">
                                        <input type="hidden" name="productName" value="{{ $product->productName }}">
                                        <input type="hidden" name="category" value="{{ $product->category }}">
                                        <input type="hidden" name="price" value="{{ $product->price }}">
                                        <input type="hidden" name="stock" value="{{ $product->stock }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="description" value="{{ $product->description }}">
                                        <input type="hidden" name="image" value="{{ $product->image }}">
                                        <input type="hidden" name="userId" value="{{ Auth::user()->userId }}">
                                        <input type="hidden" name="username" value="{{ Auth::user()->username }}">
                                        <button type="submit" class="add-to-cart-btn">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        function filterProducts(category, event) {
            // Show skeleton loading
            const productsContainer = document.getElementById('productsContainer');
            productsContainer.classList.add('loading');

            // Remove active class from all buttons
            document.querySelectorAll('nav button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            event.target.classList.add('active');

            // Update category name with fade effect
            const categoryTitle = document.getElementById('categoryName');
            categoryTitle.style.opacity = '0';
            setTimeout(() => {
                categoryTitle.textContent = category;
                categoryTitle.style.opacity = '1';
            }, 200);

            // Filter products with animation after brief loading delay
            setTimeout(() => {
                // Hide skeleton and show filtered content
                productsContainer.classList.remove('loading');

                // Filter products with animation
                const products = document.querySelectorAll('.product-card');
                products.forEach(product => {
                    const productCategory = product.querySelector('.product-category').textContent;

                    if (category === 'All' || productCategory === category) {
                        product.classList.add('fade-out');
                        setTimeout(() => {
                            product.style.display = '';
                            void product.offsetWidth;
                            product.classList.remove('fade-out');
                            product.classList.add('fade-in');
                        }, 300);
                    } else {
                        product.classList.add('fade-out');
                        setTimeout(() => {
                            product.style.display = 'none';
                            product.classList.remove('fade-in');
                        }, 300);
                    }
                });
            }, 500);
        }

        // Update the DOMContentLoaded event handler
        document.addEventListener('DOMContentLoaded', function() {
            const productsContainer = document.getElementById('productsContainer');

            // Simulate initial loading delay
            setTimeout(() => {
                // Remove loading class to hide skeletons and show products
                productsContainer.classList.remove('loading');

                // Add fade-in to all products
                document.querySelectorAll('.product-card').forEach(card => {
                    card.classList.add('fade-in');
                });
            }, 1000);
        });

        // Handle form submission confirmation
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('info') && session('confirm'))
                if (confirm("{{ session('info') }}")) {
                    let lastFormData = @json(session('lastFormData') ?? null);
                    if (lastFormData) {
                        let form = document.createElement('form');
                        form.method = 'POST';
                        form.action = lastFormData.action;

                        let csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        form.appendChild(csrfToken);

                        let confirmInput = document.createElement('input');
                        confirmInput.type = 'hidden';
                        confirmInput.name = 'confirm';
                        confirmInput.value = 'yes';
                        form.appendChild(confirmInput);

                        for (let key in lastFormData.fields) {
                            let input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = key;
                            input.value = lastFormData.fields[key];
                            form.appendChild(input);
                        }

                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            @endif
        });

        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {

                        alert.remove()
                    }, 300);
                }, 5000);
            });
        });
    </script>

</body>

</html>
