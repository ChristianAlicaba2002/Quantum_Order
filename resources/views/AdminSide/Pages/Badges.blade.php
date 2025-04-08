<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/badges.css')}}">
    <title>Document</title>
</head>

<body>


    <section>

        <div class="container-badges">

            <!-- User Badge -->
            <div class="badges">
                <h3>Users</h3>
                @php
                $users = DB::table('users')->get();
                $displayUser = $users;
                @endphp
                @if ($displayUser->count() === 0)
                <p class="text-danger">No users registered</p>
                @else
                <p>Total Users: {{ number_format($displayUser->count()) }}</p>
                @endif
            </div>

            <!-- Product Badge -->
            <div class="badges">
                <h3>Products</h3>
                @php
                $products = DB::table('products')->get();
                $displayProducts = $products;
                @endphp

                @if (isset($displayProducts))
                <p>Total products: {{ $displayProducts->count() }}</p>
                @if($displayProducts->count() == 0)
                <p class="text-danger" style="color: red;">No products available. Please add some products.</p>
                @else
                <p class="text-success" style="color: blue;">Good product !</p>
                @endif
                @endif

            </div class="badges">

            <!-- Low Stock Badge -->
            <div class="badges">

                <div>
                    <h3>Low Stock Items</h3>
                    <p>Stocks: {{ $products->where('stock', '<', 20)->count() }}</p>
                    <div>
                        <i class="fas fa-exclamation-triangle" style="color: red"></i>
                        <p class="text-muted" style="color: red">Needs attention !</p>
                    </div>
                </div>
            </div>

            <!-- Statistic Badge -->
            <div class="badges">
                <h3>Statistics</h3>
                @php
                $users = DB::table('users')->get();
                $products = DB::table('products')->get();

                $displayUser = $users;
                $displayProducts = $products;
                @endphp

                @if ($displayUser->count() === 0)
                <p>Total users: 0</p>
                @else
                <p>Total users: {{ $users->count() }}</p>
                @endif

                @if($displayProducts->count() === 0)
                <p>Total users: 0</p>
                @else
                <p>Total products: {{ $products->count() }}</p>
                @endif
            </div>


        </div>
        
    </section>

</body>

</html>