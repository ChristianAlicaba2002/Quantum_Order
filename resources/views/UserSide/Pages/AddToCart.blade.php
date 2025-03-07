@foreach ($UserAddToCart as $item)
    <div class="cart-item">
        <div class="cart-item-image">
            <img src="{{ asset('images/' . $item->image) }}" alt="Product Image" width="70">
        </div>
        <div class="cart-item-details">
            <h3>{{ $item->productName }}</h3>
            <h4>{{ $item->category }}</h4>
            <p>Price: ${{ $item->price }}</p>
            <button class="btn btn-danger" onclick="removeFromCart({{ $item->id }}, event)">Remove</button>
        </div>
    </div>
@endforeach
