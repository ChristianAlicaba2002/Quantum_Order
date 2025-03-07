<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Quantum Order</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
    /* Modern Reset & Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    :root {
        --primary-color: #ff9100;
        --primary-dark: #e07b00;
        --text-color: #2d3436;
        --bg-color: #f8f9fa;
        --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --hover-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        --border-radius: 12px;
        --spacing: 1rem;
    }

    body {
        background-color: var(--bg-color);
        color: var(--text-color);
        line-height: 1.6;
    }

    /* Modern Navigation */
    nav {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        padding: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    nav ul {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    nav ul li button {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }

    nav ul li button.active {
        background: white;
        color: var(--primary-color);
        transform: translateY(-2px);
    }

    nav ul li button:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.05);
    }

    /* Modern Product Grid */
    .products {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .product-card {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        flex-direction: column;
        box-shadow: var(--card-shadow);
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
    }

    .product-image {
        position: relative;
        overflow: hidden;
        aspect-ratio: 1;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .view-more-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.8rem 1.5rem;
        border-radius: 25px;
        opacity: 0;
        transition: all 0.3s ease;
        text-decoration: none;
        font-weight: 500;
        backdrop-filter: blur(3px);
    }

    .product-card:hover .view-more-btn {
        opacity: 1;
    }

    .product-info {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        flex: 1;
    }

    .product-name {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-color);
        margin-bottom: 0.5rem;
    }

    .product-category {
        color: #64748b;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0.5rem 0;
    }

    .add-to-cart-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 25px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: auto;
    }

    .add-to-cart-btn:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .category-name {
        padding: 2rem 2rem 0;
        max-width: 1400px;
        margin: 0 auto;
    }

    .category-name h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-color);
        position: relative;
        display: inline-block;
    }

    .category-name h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .products {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem;
        }

        .category-name h2 {
            font-size: 1.75rem;
        }
    }

    @media (max-width: 768px) {
        nav ul {
            gap: 0.3rem;
        }

        nav ul li button {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }

        .products {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            padding: 1rem;
        }

        .product-info {
            padding: 1rem;
        }

        .product-name {
            font-size: 1.1rem;
        }

        .category-name {
            padding: 1.5rem 1.5rem 0;
        }

        .category-name h2 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        nav {
            padding: 0.8rem;
        }

        nav ul {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 0.5rem;
        }

        nav ul::-webkit-scrollbar {
            height: 3px;
        }

        nav ul::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .products {
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 0.8rem;
            padding: 0.8rem;
        }

        .product-info {
            padding: 0.8rem;
        }

        .product-name {
            font-size: 1rem;
        }

        .product-price {
            font-size: 1.1rem;
        }

        .add-to-cart-btn {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }

        .category-name {
            padding: 1rem 1rem 0;
        }

        .category-name h2 {
            font-size: 1.25rem;
        }
    }

    /* Loading Animation */
    .product-card.loading {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.7;
        }

        100% {
            opacity: 1;
        }
    }

    /* Toast Notification */
    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: white;
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        z-index: 1000;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(0);
        }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }
</style>

<body>
    @include('UserSide.Pages.HeaderPage')
    <nav>
        <ul style="list-style-type: none;">
            <li>
                <button class="btn active" onclick="filterProducts('All', event)">
                    All
                </button>
            </li>
            @php
                $categories = DB::table('products')->pluck('category')->unique();
            @endphp
            @foreach ($categories as $category)
                <li>
                    <button class="btn" onclick="filterProducts('{{ $category }}',event)">
                        {{ $category }}
                    </button>
                </li>
            @endforeach
        </ul>

    </nav>

    <div>
        @if (session('success'))
            <script>
                alert("{{ session('success') }}")
            </script>
        @endif

        @if (session('error'))
            <script>
                alert("{{ session('error') }}")
            </script>
        @endif


        <div class="category-name">
            <h2 id="categoryName">All</h2>
        </div>

        <div class="products">
            @php
                $products = DB::table('products')->get();
            @endphp
            @if ($products->isEmpty())
                <h3>No available products</h3>
            @else
                @foreach ($products->sortBy('price') as $product)
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset('/images/' . $product->image) }}" alt="{{ $product->productName }}"
                                data-src="{{ asset('/images/' . $product->image) }}" class="lazy">
                            <a class="view-more-btn"
                                href="/ProductDetails/{{ $product->productId }}/{{ $product->productName }}/{{ $product->category }}/{{ $product->price }}/{{ $product->stock }}/{{ $product->description }}/{{ $product->image }}">View
                                more</a>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->productName }}</h3>
                            <p class="product-category">{{ $product->category }}</p>
                            <p class="product-category">{{ $product->description }}</p>
                            <p class="product-price">&#8369;{{ number_format($product->price) }}</p>
                            <form action="{{ route('addtocart', ['id' => $product->productId]) }}" method="POST"
                                class="add-to-cart-form">
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
                                <button type="submit" class="add-to-cart-btn">Add to cart</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>



    </div>

    <script>
        function filterProducts(category, event) {
            document.querySelectorAll('nav .btn').forEach(btn => {
                btn.classList.remove('active');
            });

            event.target.classList.add('active');

            const products = document.querySelectorAll('.products > div');
            document.getElementById('categoryName').textContent = category;

            products.forEach(product => {
                const productCategory = product.querySelector('p').textContent;

                if (category === 'All' || productCategory === category) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            });
        }



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

                        // Add all the form fields
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

        // Smooth scroll for navigation
        document.querySelectorAll('nav button').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(button.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add to cart animation
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <span>${message}</span>
            `;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Lazy loading for images
        document.addEventListener('DOMContentLoaded', () => {
            const images = document.querySelectorAll('.product-image img');
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => {
                imageObserver.observe(img);
            });
        });
    </script>

</body>

</html>
