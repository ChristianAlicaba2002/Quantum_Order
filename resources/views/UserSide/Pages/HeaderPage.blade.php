<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/headerpage.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>{{ Auth::user()->firstName ?? 'Home' }}</title>

    <style>
   
</style>

</head>

<body>

    <header class="mainHeader">
        <h1>Quantum Order</h1>
        <div class="Icons">
            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                <img style="width:2rem" src="{{ asset('assets/house-door.svg') }}" alt="Home" srcset="">
            </a>
        </div>

        <div class="SearchItemsInput">
            <input type="text" placeholder="Search your item" oninput="searchProducts(this.value)"
                class="search-input">
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
                $product = DB::table('add_to_cart')
                    ->where('userId', Auth::user()->userId)
                    ->get();
                $productCount = $product;
                ?>
                <label for="">{{ $productCount->count() }}</label>
            </div>
        </div>



        <div class="AddToCartDivision" id="AddToCartDivision">


            <?php
            $product = DB::table('add_to_cart')
                ->where('userId', Auth::user()->userId)
                ->get();
            $AddToCartItem = $product;
            ?>

            <div class="cart-title">
                <h1>Shopping Cart <span style="color:{{ $AddToCartItem->count() === 0 ? 'red ' : 'black' }} ">
                        ({{ $AddToCartItem->count() }})</span></h1>
            </div>

            @foreach ($AddToCartItem as $item)
                <div class="cart-item">
                    <input class="" type="checkbox" name="" id="" onclick="calculateTotal()">
                    <div class="cart-item-image">
                        <img src="{{ asset('images/' . $item->image) }}" alt="Product Image" loading="lazy">
                    </div>
                    <div class="cart-item-details">
                        
                        <h3>{{ $item->productName }}</h3>
                        <h4>{{ $item->category }}</h4>
                        <h4>{{ $item->quantity }}x</h4>
                        <!-- <label>{{ $item->description }}</label> -->
                        <p>Price:&#8369;
                            <span class="item-price">{{ number_format($item->price, 2) }}</span>
                        </p>            
                    </div>
                       
                    <div class="ItemButtons">
                       
                        <button type="button" onclick="updateQuantity(this, -1, {{ $item->stock }})">-</button>
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->stock }}" readonly class="">
                        <button type="button" onclick="updateQuantity(this, 1, {{ $item->stock }})">+</button>
                        <!-- <form action="/removefromcart/{{ $item->productId }}" method="post">
                            @csrf
                            <button class="btn btn-danger"><i class="fa-solid fa-xmark"></i></button>
                        </form> -->
                    </div>
                        <div class="RemoveButton">
                            <form action="/removefromcart/{{ $item->productId }}" method="post">
                                @csrf
                                <button type="submit" style="width: 20px; background-color:transparent; border:0;outline:0;"><i class="fa-solid fa-xmark"></i></button>
                            </form>
                        </div>
                </div>
            @endforeach

            @if (count($AddToCartItem) === 0)
                <div class="NoItemsMessage">
                    <h1 style="color: black">No items in your cart</h1>
                </div>
            @else
                <div class="checkoutITems">
                    <div>
                        <input type="checkbox" name="selectedItems[]" id="checkAll" onclick="toggleCheckAll(this)">
                        <label style="cursor: pointer" for="checkAll">All</label>
                    </div>
                    <div class="Total-Amount">
                        <label for="">Total :</label>
                        <span style="color: red" id="totalPrice">&#8369; 0.00</span>
                        <a href="#" onclick="proceedToCheckout()" class="checkout-btn">Check out</a>
                    </div>
                </div>
            @endif

        </div>

        <div class="userinformation dropdown">
            <div class="dropdown-trigger">
                <img src="{{ asset('/images/' . Auth::user()->image) }}"
                    alt="{{ Auth::user()->firstName }}'s profile picture"
                    style="width: 2.3rem; height: 2.3rem; object-fit: cover; border-radius: 50%;">

            </div>
            <div class="dropdown-content">
                <a href="{{ route('UserInformationPage') }}">{{ Auth::user()->firstName }}</a>
                <a href="{{ route('user.to-pay-history') }}">To pay</a>
                <a href="{{ route('user.to-delivery-history') }}">Delivery</a>
                <a href="{{ route('user.received-history') }}">Received</a>
                <a href="{{ route('user.cancelled-history') }}">Cancelled</a>
                <form action="{{ route('auth.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="icon-button">
                        <i class="bi bi-box-arrow-right" style="margin-right:.80rem;"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <script>
        function searchProducts(searchText) {
            const products = document.querySelectorAll('.product-card');
            const searchTerm = searchText.toLowerCase().trim();

            // Reset all products if search is empty
            if (searchTerm === '') {
                products.forEach(product => {
                    product.style.opacity = '1';
                    product.style.display = '';
                });
                const existingMessage = document.getElementById('noResultsMessage');
                if (existingMessage) {
                    existingMessage.remove();
                }
                return;
            }

            let hasResults = false;

            products.forEach(product => {
                const productName = product.querySelector('.product-name').textContent.toLowerCase().trim();
                const productCategory = product.querySelector('.product-category').textContent.toLowerCase().trim();
                const price = product.querySelector('.price').textContent.toLowerCase().trim();

                const isMatch =
                    productName.includes(searchTerm) ||
                    productCategory.includes(searchTerm) ||
                    price.includes(searchTerm) ||
                    productName.split(' ').some(word => word === searchTerm) ||
                    productCategory.split(' ').some(word => word === searchTerm);

                if (isMatch) {
                    hasResults = true;
                    product.style.display = '';
                    product.style.opacity = '0';
                    requestAnimationFrame(() => {
                        product.style.opacity = '1';
                    });
                } else {
                    product.style.opacity = '0';
                    setTimeout(() => {
                        product.style.display = 'none';
                    }, 300);
                }
            });

            // Handle no results message
            const noResultsMsg = document.getElementById('noResultsMessage');
            if (!hasResults) {
                if (!noResultsMsg) {
                    const message = document.createElement('div');
                    message.id = 'noResultsMessage';
                    message.style.cssText = `
                        width: 100%;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        padding: 40px;
                        grid-column: 1 / -1;
                    `;
                    message.innerHTML = `
                        <h3 style="color: #666; font-size: 18px;">No products found for "${searchText}"</h3>
                    `;
                    document.querySelector('#productsList').appendChild(message);
                }
            } else if (noResultsMsg) {
                noResultsMsg.remove();
            }
        }

        function closeModal() {
            document.getElementById('AddToCartDivision').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('AddToCartDivision');
            if (event.target == modal) {
                closeModal();
            }
        }

        const cartIcon = document.getElementById('cartIcon');
        const cartDropdown = document.getElementById('AddToCartDivision');
        const backdrop = document.createElement('div');
        backdrop.className = 'cart-backdrop';
        document.body.appendChild(backdrop);

        function openCart(event) {
            if (event) {
                event.stopPropagation();
            }

            cartDropdown.style.display = 'block';
            backdrop.style.display = 'block';

            void cartDropdown.offsetWidth;

            cartDropdown.classList.add('show');
            backdrop.classList.add('show');
        }

        function closeCart() {
            backdrop.classList.remove('show');
            cartDropdown.classList.remove('show');

            setTimeout(() => {
                cartDropdown.style.display = 'none';
                backdrop.style.display = 'none';
            }, 300);
        }

        cartIcon.addEventListener('click', (event) => {
            if (cartDropdown.style.display === 'none' || cartDropdown.style.display === '') {
                openCart(event);
            } else {
                closeCart();
            }
        });

        cartDropdown.addEventListener('click', (event) => {
            event.stopPropagation();
        });

        backdrop.addEventListener('click', closeCart);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && cartDropdown.style.display === 'block') {
                closeCart();
            }
        });

        function calculateTotal() {
            let total = 0;
            const cartItems = document.querySelectorAll('.cart-item');
            
            cartItems.forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    const price = parseFloat(item.querySelector('.item-price').textContent.replace(/[^\d.-]/g, ''));
                    const quantity = parseInt(item.querySelector('input[name="quantity"]').value);
                    total += price * quantity;
                }
            });

            document.getElementById('totalPrice').textContent = '₱ ' + total.toFixed(2);
        }

        function toggleCheckAll(source) {
            const checkboxes = document.querySelectorAll('.cart-item input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
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


        function proceedToCheckout() {
            const cartItems = document.querySelectorAll('.cart-item');
            const selectedItems = [];
            let totalPrice = 0;

            // Check if any items are selected
            const hasSelectedItems = Array.from(cartItems).some(item => 
                item.querySelector('input[type="checkbox"]').checked
            );

            if (!hasSelectedItems) {
                alert('Please select at least one item to checkout');
                return false;
            }

            // Collect data from selected items
            cartItems.forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    // Get the form element to extract the product ID
                    const form = item.querySelector('form');
                    const productId = form.action.split('/').pop();
                    
                    const itemDetails = {
                        productId: productId,
                        productName: item.querySelector('.cart-item-details h3').textContent.trim(),
                        category: item.querySelector('.cart-item-details h4').textContent.trim(),
                        quantity: parseInt(item.querySelector('input[name="quantity"]').value),
                        price: parseFloat(item.querySelector('.item-price').textContent.replace(/[^\d.-]/g, '')),
                        image: item.querySelector('.cart-item-image img').src.split('/').pop(),
                        stock: parseInt(item.querySelector('input[name="quantity"]').getAttribute('max'))
                    };
                    
                    selectedItems.push(itemDetails);
                    totalPrice += itemDetails.price * itemDetails.quantity;
                }
            });

            // Create and submit form
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = '{{ route("checkout.preview") }}';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            // Add selected items as JSON string
            const itemsInput = document.createElement('input');
            itemsInput.type = 'hidden';
            itemsInput.name = 'selectedItems';
            itemsInput.value = JSON.stringify(selectedItems);
            form.appendChild(itemsInput);

            // Add total price
            const totalPriceInput = document.createElement('input');
            totalPriceInput.type = 'hidden';
            totalPriceInput.name = 'totalPrice';
            totalPriceInput.value = totalPrice.toFixed(2);
            form.appendChild(totalPriceInput);

            // Append form to body and submit
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>

</html>