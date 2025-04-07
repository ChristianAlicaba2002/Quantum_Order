<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <title>Quantum Order</title>
    <link rel="stylesheet" href="{{asset('css/mainpage.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<style>
   
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
                                    <label for="" style="font-size: .80rem;">

                                        @if (floatval($product->stock) >= 50)
                                            ⭐⭐⭐⭐⭐
                                        @elseif (floatval($product->stock) > 40)
                                            ⭐⭐⭐⭐
                                        @elseif (floatval($product->stock) > 30)
                                            ⭐⭐⭐
                                        @elseif(floatval($product->stock) > 20)
                                            ⭐⭐
                                        @else
                                            ⭐
                                        @endif
                                    </label>
                                </div>
                                    @if ( number_format($product->stock) == 0 )
                                        <p class="price" style="color:red; font-size:small;">Out of Stock</p>
                                    @else
                                        <p class="price" style="color:red; font-size:small">Stock: {{ $product->stock }}</p>
                                    @endif
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

                                        @if ( number_format($product->stock) == 0 )
                                        <button type="submit" class="add-to-cart-btn" disabled style="cursor:not-allowed">
                                            <i class="bi bi-cart-plus"></i>
                                            Out of Stock
                                        </button>
                                        @else
                                        <button type="submit" class="add-to-cart-btn">
                                            <i class="bi bi-cart-plus"></i>
                                            Add to Cart
                                        </button>
                                        @endif  
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
