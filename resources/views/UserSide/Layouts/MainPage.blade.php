<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Quantum Order</title>
</head>


<body>
    @section('MainPage')
            <header>
                <h1>Quantum Order</h1>
                <img style="width:2rem" src="./assets/house-door.svg" alt="" srcset="">
                <div>
                    <input type="search" name="" id="SearchItem" placeholder="Search your item">
                    <button type="submit">Search</button>
                </div>
                <img style="width:2rem" src="./assets/person.svg" alt="" srcset="">
                <img style="width:2rem" src="./assets/cart.svg" alt="" srcset="">
            </header>
            <form action="{{ route('auth.logout') }}" method="post">
                @csrf
                <button type="submit">Logout</button>
            </form>

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

            
            <div class="products">
                @foreach ($products->sortBy('price') as $product)
                    <div>
                        <img src="{{ asset('/images/' . $product->image) }}" alt="{{ $product->productName }}"
                            style="width: 50px; height: 50px; object-fit: cover;">
                        <h1>{{$product->productName}}</h1>
                        <h5>{{$product->category}}</h5>
                        <p>{{number_format( $product->price)}}</p>
                        <div>
                            <button type="submit">Add to cart</button>
                        </div>
                    </div>    
                @endforeach
            </div>

        </div>
    @endsection


    <script>
        function filterProducts(category, event) {
            document.querySelectorAll('nav .btn').forEach(btn => {
                btn.classList.remove('active');
            });

            event.target.classList.add('active');

            const products = document.querySelectorAll('.products > div');

            products.forEach(product => {
                const productCategory = product.querySelector('h5').textContent;
                
                if (category === 'all' || productCategory === category) {
                    product.style.display = ''; 
                } else {
                    product.style.display = 'none'; 
                }
            });
        }
    </script>

</body>

</html>
