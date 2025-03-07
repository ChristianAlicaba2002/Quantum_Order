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
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        font-size: 12px;
        margin: 0;
        padding: 0;
        background-color: #ffffff;
        color: #333;
        width: 100%;
    }

    nav {
        background-color: #ff9100;
        margin: 0;
        padding: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    nav ul {
        list-style-type: none;
        padding: 0;
        display: flex;
        justify-content: center;
    }

    nav ul li {
        margin: 0 10px;
    }

    nav ul li button {
        background-color: transparent;
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s, color 0.3s;
        border-radius: 5px;
    }

    nav ul li button.active {
        background-color: #fff;
        color: #ff9100;
    }

    nav ul li button:hover {
        color: #000000;
        background-color: #ffffff8d;
    }

    .add-to-cart-btn:hover {
        background-color: #e07b00;
    }

    #totalPrice {
        font-size: 14px;
        font-weight: bold;
        color: #ff9100;
    }

    input[type="checkbox"] {
        margin-right: 5px;
    }

    .products {
        display: flex;
        flex: 2;
        flex-wrap: wrap;
        margin-left: 1.4rem;
        gap: 1.5%;
    }

    .products>div {
        background-color: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        margin: 10px;
        padding: 10px;
        max-width: 16%;
        transition: box-shadow 0.3s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .products>div:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .product-card {
        background-color: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        margin: 10px;
        padding: 10px;
        width: calc(25% - 20px);
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .product-image {
        position: relative;
    }

    .product-image img {
        border-radius: 10px;
        width: 100%;
        height: 25vh;
    }

    .view-more-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 10px;
        cursor: pointer;
        display: none;
        text-decoration: none;
        transition: 1s ease-in-out linear;
    }

    .product-card:hover .view-more-btn {
        display: block;
    }

    .product-info {
        margin-top: 5px;
    }

    .product-name {
        text-align: left;
        font-size: 16px;
        margin: 5px 0;
    }

    .product-category {
        font-size: 14px;
        text-align: left;
        color: #666;
    }

    .product-price {
        text-align: left;
        font-size: small;
        color: #ff0000;
        /* margin: 10px 0; */
    }

    .add-to-cart-btn {
        background-color: #ff9100;
        color: white;
        border: none;
        padding: 8px 10px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
        float: right;
    }

    .add-to-cart-btn:hover {
        background-color: #e07b00;
    }

    .category-name h2 {
        font-size: 24px;
        margin: 20px 2%;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<body>
    @include('UserSide.Pages.HeaderPage')
    <nav>
        <ul>
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
                            <img src="{{ asset('/images/' . $product->image) }}" alt="{{ $product->productName }}">
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
    </script>

</body>

</html>
