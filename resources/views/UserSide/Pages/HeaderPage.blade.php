<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Document</title>
</head>
<style>
    *{
        font-family: Arial, Helvetica, sans-serif;
    }
    .mainHeader{
        display: flex;
        background-color: rgb(255, 255, 255);
        width: 100%;
        position: sticky;
        top: 0;
        z-index: 10;
        box-shadow: 0 0 1px black;
    }
    .mainHeader h1{
        font-size: 1.3rem;
        margin: 1.1rem 0 1rem 1rem;
        min-width: 14%;
        text-align: center;
        /* background-color: red; */
    }
    .SearchItemsInput{
        margin: .70rem 1.1rem;
        width: 60%;
    }
    .SearchItemsInput input{
        width: 100%;
        padding: .70rem;
        outline: 0;
        border: 2px solid transparent;
        border-radius: 5px;
        background-color: rgb(242, 242, 242);
        transition: .2s ease-in-out;
    }
    .SearchItemsInput input:focus{
        border: 2px solid orange;
    }
    .dropdown {
        position: relative;
        display: inline-block;
        margin-top: .70rem;
        margin-left: 2%;
    }
    
    .dropdown-trigger {
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.2rem;
    }
    
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        border-radius: 5%;
        padding: 8px 0;
        margin-left: -7.5rem;
        font-size: large;
    }
    .dropdown-content label{
        padding: 20px 0 20px 16px;
    }
    
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    
    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }
    
    .dropdown:hover .dropdown-content {
        display: block;
    }
    
    .icon-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 12px 16px;
        width: 100%;
        display: flex;
        align-items: center;
        text-align: left
    }
    
    .icon-button:hover {
        background-color: #f1f1f1;
    }
    .IsFound{
        color: red;
        font-weight: bold;
        margin-right: 10px;
        margin-left:40rem;
        margin-bottom: 10px;
        margin-top: 10rem;
        position: absolute;
        display: none;
    }
    .cartNumber{
       width: 5%;
       text-align: center;
       margin-left: 2%;
    }
    .cartNumber img{
        margin-top: .70rem;
    }
    .cartGroup{
        width: .79rem;
        height: .80rem;
        background-color: red;
        text-align: center;
        border-radius: 50%;
        padding: .15rem;
        font-size: small;
        position: relative;
        margin-top: -2.6rem;
        margin-left: 2.5rem;
    }.cartGroup label{
        color: rgb(255, 255, 255);
        position: relative;
    }
    
    .AddToCartDivision{
        width: 35%;
        box-shadow: 0 0 1px rgb(0, 0, 0);
        border-radius: 2%;
        background-color: white;
        position: absolute;
        margin-top: 3.8rem;
        margin-left: 65%;
        z-index: 10;
        display:none;
        height: 75vh;
        overflow-y: scroll;
        overflow-x: hidden;
    }
    .AddToCartDivision h1{
        width: 100%;
        background-color: rgb(255, 255, 255);
        padding: 1.1rem 0 1.1rem 1rem;
        top: 0;
        position: sticky;
        /* border-bottom: 1px solid rgba(0, 0, 0, 0.505); */
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #eee;
        background-color: #fff8f0;
        margin: 5px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        max-width: 100%;
    }

    .cart-item-image img {
        border-radius: 10px;
        width: 100px;
        height: 60px;
        object-fit: cover;
    }

    .cart-item-details {
        display: block;
        margin-left: 10px;
        flex-grow: 1;
    }

    .cart-item-details h3,
    .cart-item-details h4 {
        font-size: 14px;
        margin: 5px 0;
    }
    .ItemButtons{
        display: flex;
        flex-direction: row;
    }

    .ItemButtons button {
        background-color: #ff9100;
        color: #fff;
        border: none;
        padding: 3px 10px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s;
        font-size: 12px;
    }

    .ItemButtons button:hover {
        background-color: #e07b00;
    }

    .checkoutITems{
        background-color: #ffffff;
        position: sticky;
        bottom: 0;
        padding: 1.2rem;
        border-top: 1px solid rgba(0, 0, 0, 0.505);
    }
    .NoItemsMessage{
        width: 100%;
        height: 50vh;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .active {
        color: #ff9100;
        border-bottom: 2px solid orange;
    }

    .Icons{
        margin-top: 1rem;
    }
    .Icons a:nth-child(2){
        margin-right: 5rem;
    }

    a {
        text-decoration: none;
        color: #333;
        padding: 11px 10px;
        transition: background-color 0.3s ease;
    }

    .checkout-details {
        margin: 15px 0;
    }

    .form-group {
        margin-bottom: 10px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group input {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 200px;
    }

    .checkout-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #ff9100;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
    }

    .checkout-btn:hover {
        background-color: #e68200;
    }

</style>
<body>

<header class="mainHeader">
    <h1>Quantum Order</h1>
    <div class="Icons">
        <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
            <img style="width:2rem" src="{{ asset('assets/house-door.svg') }}" alt="Home" srcset="">
        </a>
    </div>
    
        <div class="SearchItemsInput">
            <input type="search" placeholder="Search your item" onkeyup="searchProducts(this.value)">
        </div>

    <div class="Icons">
        <a href="/MainPage" class="{{ request()->is('MainPage') ? 'active' : '' }}">
            <img style="width:2rem" src="{{ asset('assets/box-seam.svg') }}" alt="Products" srcset="">
        </a>
    </div>

    <div class="cartNumber">
        <img id="cartIcon" style="width:2rem" src="./assets/cart.svg" alt="" srcset="">
            <div class="cartGroup">
                <?php  
                    $product = DB::table('add_to_cart')->where('userId',Auth::user()->userId)->get(); 
                    $productCount = $product;
                ?>
            <label for="">{{$productCount->count()}}</label>
            </div>
    </div>
    

            
<div class="AddToCartDivision" id="AddToCartDivision">
 

    <?php
        $product = DB::table('add_to_cart')->where('userId',Auth::user()->userId)->get(); 
        $AddToCartItem = $product;
    ?>

    <div class="cart-title">
        <h1>Shopping Cart <span style="color:{{$AddToCartItem->count() === 0 ? 'red ' : 'black' }} "> ({{$AddToCartItem->count()}})</span></h1>
    </div>

    @foreach ($AddToCartItem as $item)
        <div class="cart-item">
            <input class="" type="checkbox" name="" id="" onclick="calculateTotal()">
            <div class="cart-item-image">
                <img src="{{ asset('images/'. $item->image)}}" alt="Product Image">
            </div>
            <div class="cart-item-details">
                <h3>{{ $item->productName }}</h3>
                <h4>{{ $item->category }}</h4>
                <h4>x{{$item->quantity}}</h4>
                <label>{{ $item->description }}</label>
                <p style="color: red">Price:&#8369;<span class="item-price">{{ $item->price }}</span></p>
            </div>
            <div class="ItemButtons">
                <button type="button" onclick="updateQuantity(this, -1, {{ $item->stock }})">-</button>
                <input type="number" name="quantity" value="{{$item->quantity}}" min="1" max="{{$item->stock}}" readonly>
                <button type="button" onclick="updateQuantity(this, 1, {{ $item->stock }})">+</button>
                <form action="/removefromcart/{{$item->productId}}" method="post">
                    @csrf
                     <button class="btn btn-danger"><i class="fa-solid fa-xmark"></i></button>
                </form>
            </div>
             
        </div>
    @endforeach

    @if(count($AddToCartItem) === 0)
        <div class="NoItemsMessage">
            <h1 style="color: black">No items in your cart</h1>
        </div>
    @else
        <div class="checkoutITems">
            <input type="checkbox" name="selectedItems[]" id="checkAll" onclick="toggleCheckAll(this)">
            <label style="cursor: pointer" for="checkAll">All</label>     
            <label for="">Total :</label>
            <span style="color: red" id="totalPrice">&#8369; 0.00</span>
            <div>
                <a href="#" onclick="proceedToCheckout()" class="checkout-btn">Check out</a>
            </div>
            
        </div>
    @endif

</div>



    <div class="userinformation dropdown">
        <div class="dropdown-trigger">
            <img src="{{ asset('/images/' . Auth::user()->image)}}" 
            alt="{{ Auth::user()->firstName }}'s profile picture"
            style="width: 2.3rem; height: 2.3rem; object-fit: cover; border-radius: 50%;">
           
        </div>
        <div class="dropdown-content">
            <a href="{{route('UserInformationPage')}}">{{Auth::user()->firstName}}</a>
            <a href="{{route('user.to-pay-history')}}">To pay</a>
            <a href="{{route('user.to-delivery-history')}}">Delivery</a>
            <a href="{{route('user.received-history')}}">Received</a>
            <a href="{{route('user.cancelled-history')}}">Cancelled</a>
            <form action="{{ route('auth.logout') }}" method="post">
                @csrf
                <button type="submit" class="icon-button">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</header>




<script>

    function searchProducts(searchText) {
            const products = document.querySelectorAll('.products > div');
            const isfound = document.getElementById('isfound');
                searchproductsText = searchText.toLowerCase();

                products.forEach(product => {
                    const productName = product.querySelector('h3').textContent.toLowerCase();
                    
                    if (productName.includes(searchText)) {
                        product.style.display = '';
                        document.body.style.backgroundColor = 'white'
                        
                    } else {
                        product.style.display = 'none';
                        // document.body.style.backgroundColor = 'lightgray'
                    }
                });
        
        }

    document.getElementById('cartIcon').addEventListener('click', function() {
        const addToCartDivision = document.getElementById('AddToCartDivision');
        if (addToCartDivision) {
            if (addToCartDivision.style.display === 'none' || addToCartDivision.style.display === '') {
                addToCartDivision.style.display = 'block';
            } else {
                addToCartDivision.style.display = 'none';
            }
        }
    });

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

    function proceedToCheckout() {
        // Check if any items are selected
        const checkboxes = document.querySelectorAll('.cart-item input[type="checkbox"]:checked');
        if (checkboxes.length === 0) {
            alert('Please select at least one item to checkout');
            return false;
        }

        // Create a form to submit the selected items
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("checkout.preview") }}';
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Get selected items and add to form
        let totalAmount = 0;
        checkboxes.forEach((checkbox, index) => {
            const cartItem = checkbox.closest('.cart-item');
            
            // Get product details
            const productId = cartItem.querySelector('form').action.split('/').pop();
            const productName = cartItem.querySelector('h3').textContent;
            const category = cartItem.querySelector('h4').textContent;
            const price = parseFloat(cartItem.querySelector('.item-price').textContent);
            const quantity = parseInt(cartItem.querySelector('input[type="number"]').value);
            const image = cartItem.querySelector('img').src.split('/').pop();
            
            // Calculate subtotal
            const subtotal = price * quantity;
            totalAmount += subtotal;
            
            // Add fields to form
            const fields = {
                'productId': productId,
                'productName': productName,
                'category': category,
                'price': price,
                'quantity': quantity,
                'image': image
            };
            
            for (const [key, value] of Object.entries(fields)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `items[${index}][${key}]`;
                input.value = value;
                form.appendChild(input);
            }
        });
        
        // Add total price
        const totalPriceInput = document.createElement('input');
        totalPriceInput.type = 'hidden';
        totalPriceInput.name = 'totalPrice';
        totalPriceInput.value = totalAmount.toFixed(2);
        form.appendChild(totalPriceInput);
        
        // Submit the form
        document.body.appendChild(form);
        form.submit();
        
        return false;
    }
</script>

    
</body>
</html>

