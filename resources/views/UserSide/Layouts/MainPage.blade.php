<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Quantum Order</title>
</head>

<style>

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

        
            <div class="products">
                @if ($products->isEmpty())
                    <h3>No available products</h3>
                @else
                    @foreach ($products->sortBy('price') as $product)
                        <div>
                            <img src="{{ asset('/images/' . $product->image) }}" alt="{{ $product->productName }}"
                                style="width: 50px; height: 50px; object-fit: cover;">
                            <h1>{{$product->productName}}</h1>
                            <h4>{{$product->category}}</h4>
                            <h5>{{$product->description}}</h5>
                            <p>{{number_format( $product->price)}}</p>
                            <div>
                                <button type="submit">Add to cart</button>
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

            products.forEach(product => {
                const productCategory = product.querySelector('h4').textContent;
                
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
