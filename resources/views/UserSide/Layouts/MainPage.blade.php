<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Quantum Order</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
     body {
        font-size: 12px;
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
        color: #333;
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
        border-radius: 10px;
    }

    nav ul li button.active,
    nav ul li button:hover {
        background-color: #fff;
        color: #ff9100;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #eee;
        background-color: #fff;
        margin: 5px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .cart-item-image img {
        border-radius: 10px;
        width: 60px;
        height: 60px;
        object-fit: cover;
    }

    .cart-item-details {
        margin-left: 10px;
        flex-grow: 1;
    }

    .cart-item-details h3,
    .cart-item-details h4 {
        font-size: 14px;
        margin: 5px 0;
    }

    .cart-item-details button {
        background-color: #ff9100;
        color: #fff;
        border: none;
        padding: 3px 10px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
        font-size: 12px;
    }

    .cart-item-details button:hover {
        background-color: #e07b00;
    }

    .products {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .products > div {
        background-color: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        margin: 10px;
        padding: 10px;
        width: calc(25% - 20px);
        text-align: center;
        transition: box-shadow 0.3s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .products > div:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .products img {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 10px;
    }

    .add-to-cart-btn {
        background-color: #ff9100;
        color: white;
        border: none;
        padding: 5px 15px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
        font-size: 12px;
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
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .view-more-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.5);
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        display: none;
    }

    .product-card:hover .view-more-btn {
        display: block;
    }

    .product-info {
        margin-top: 10px;
    }

    .product-name {
        font-size: 16px;
        margin: 5px 0;
    }

    .product-category {
        font-size: 14px;
        color: #666;
    }

    .product-price {
        font-size: 18px;
        color: #ff9100;
        margin: 10px 0;
    }

    .add-to-cart-btn {
        background-color: #ff9100;
        color: white;
        border: none;
        padding: 5px 15px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .add-to-cart-btn:hover {
        background-color: #e07b00;
    }

    .category-name h2 {
        font-size: 24px;
        margin: 20px 0;
    }
</style>

<body>
        @include('UserSide.Pages.HeaderPage')           

        <div>
            <nav>
                <ul>
                    <li>
                        <button class="btn active" onclick="filterProducts('all', event)">
                            All
                        </button>
                    </li>
                    @php
                        $categories = $products->pluck('category')->unique();
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
       

            <div class="AddToCartDivision" id="AddToCartDivision" style="background-color:#ff9100; display:none">
                <h1>Shopping Cart</h1>
                <?php
                    $product = DB::table('add_to_cart')->where('userId',Auth::user()->userId)->get(); 
                    $AddToCartItem = $product;
                ?>
                @foreach ($AddToCartItem as $item)
                    <div class="cart-item">
                        <input class="" type="checkbox" name="" id="" onclick="calculateTotal()">
                        <div class="cart-item-image">
                            <img src="{{ asset('images/'. $item->image)}}" alt="Product Image" width="70">
                        </div>
                        <div class="cart-item-details">
                            <h3>{{ $item->productName }}</h3>
                            <h4>{{ $item->category }}</h4>
                            <h4>x{{$item->quantity}}</h4>
                            <label>{{ $item->description }}</label>
                            <p>Price:&#8369;<span class="item-price">{{ $item->price }}</span></p>
                            <div>
                               <button type="button" onclick="updateQuantity(this, -1, {{ $item->stock }})">-</button>
                               <input type="number" name="quantity" value="1" min="1" max="{{$item->stock}}" readonly>
                               <button type="button" onclick="updateQuantity(this, 1, {{ $item->stock }})">+</button>
                            </div>
                            <form action="/removefromcart/{{$item->productId}}" method="post">
                                @csrf
                                <button class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                @endforeach

                @if(count($AddToCartItem) > 0)
                    <input type="checkbox" name="" id="checkAll" onclick="toggleCheckAll(this)">
                    <label style="cursor: pointer" for="checkAll">All</label> 
                @endif
                <div>
                    <label for="">Total :</label>
                    <span style="color: red" id="totalPrice">&#8369; 0.00</span>
                    <form action="/checkout/{{$item->productId}}" method="post">
                        @csrf
                        <input type="hidden" name="productId" value="{{$item->productId}}">
                        <input type="hidden" name="productName" value="{{$item->productName}}">
                        <input type="hidden" name="category" value="{{$item->category}}">
                        <input type="hidden" name="userId" value="{{ Auth::user()->userId }}">
                        <input type="hidden" name="firstName" value="{{ Auth::user()->firstName }}">
                        <input type="hidden" name="address" value="{{ Auth::user()->address }}">
                        <input type="hidden" name="phoneNumber" value="{{ Auth::user()->phoneNumber }}">
                        <input type="hidden" name="totalPrice" id="totalPriceValue">
                        <input type="hidden" name="stock" value="{{$item->stock}}">
                        <button type="submit">Checkout</button>
                        <button type="submit">Check out</button>
                    </form>
                </div>
                
                
            </div>

        
            <div class="category-name">
                <h2 id="categoryName">All</h2>
            </div>

            <div class="products">
                @if ($products->isEmpty())
                    <h3>No available products</h3>
                @else
                    @foreach ($products->sortBy('price') as $product)
                        <div class="product-card">
                            <div class="product-image">
                                <img src="{{ asset('/images/' . $product->image) }}" alt="{{ $product->productName }}">
                                <button class="view-more-btn">View more</button>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">{{ $product->productName }}</h3>
                                <p class="product-category">{{ $product->category }}</p>
                                <p class="product-price">&#8369;{{ number_format($product->price) }}</p>
                                <button class="add-to-cart-btn">Add to cart</button>
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
                const productCategory = product.querySelector('h4').textContent;
                
                if (category === 'all' || productCategory === category) {
                    product.style.display = ''; 
                } else {
                    product.style.display = 'none';
                }
            });
        }

        function toggleCheckAll(checkbox) {
            const checkboxes = document.querySelectorAll('.cart-item input[type="checkbox"]');
            checkboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
        }

        function toggleCheckAll(checkbox) {
            const checkboxes = document.querySelectorAll('.cart-item input[type="checkbox"]');
            checkboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
            calculateTotal();
        }

        function updateQuantity(button, change, maxStock) {
            const quantityInput = button.parentElement.querySelector('input[name="quantity"]');
            let currentQuantity = parseInt(quantityInput.value);
            currentQuantity += change;

            if (currentQuantity < 1) {
                currentQuantity = 1;
            } else if (currentQuantity > maxStock) {
                currentQuantity = maxStock;
            }

            quantityInput.value = currentQuantity;
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            const cartItems = document.querySelectorAll('.cart-item');
            cartItems.forEach(cartItem => {
                const checkbox = cartItem.querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    const priceText = cartItem.querySelector('.item-price').textContent;
                    const price = parseFloat(priceText);
                    const quantity = parseInt(cartItem.querySelector('input[name="quantity"]').value);
                    total += price * quantity;
                }
            });
            document.getElementById('totalPrice').textContent = `₱ ${total.toFixed(2)}`;
        }
    </script>

</body>

</html>
