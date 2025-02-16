@section('BadgesContent')
<div class="container badges">

    <div>
        <h3>Users</h3>
        <p>Total users: {{ $users->count() }}</p>
        <p>Total user registered</p>
    </div>

    <div>
        <h3>Products</h3>
        <p>Total products: {{ $products->count() }}</p>
        @if($products->count() == 0)
            <p class="text-danger">No products available. Please add some products.</p>
        @elseif($products->count() < 5)
            <p class="text-warning">Low product count. Consider adding more products.</p>
        @else
            <p class="text-success">Good product!</p>
        @endif
    </div>

    <div>
        <h3>Statistics</h3>
        <p>Total users: {{ $users->count() }}</p>
        <p>Total products: {{ $products->count() }}</p>
    </div>


</div>
    
@endsection