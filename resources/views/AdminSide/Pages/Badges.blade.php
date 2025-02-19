@section('BadgesContent')
<div class="container badges">

    <div>
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

    <div>
        <h3>Products</h3>
        @php
            $products = DB::table('products')->get();
            $displayProducts = $products;
        @endphp
        
        @if (isset($displayProducts))    
            <p>Total products: {{ $displayProducts->count() }}</p>
            @if($displayProducts->count() == 0)
                <p class="text-danger">No products available. Please add some products.</p>
            @else
                <p class="text-success">Good product!</p>
            @endif
        @endif

    </div>

    <div >
        <div >
            <div >
                <h3>Low Stock Items</h3>
                <p>Stocks: {{ $products->where('stock', '<', 20)->count() }}</p>
                <div>
                    <i class="fas fa-exclamation-triangle"></i>
                    <small class="text-muted">Needs attention</small>
                </div>
            </div>
        </div>
    </div>

    <div>
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
    
@endsection