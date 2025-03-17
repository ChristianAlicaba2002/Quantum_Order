@foreach ($UserAddToCart as $item)
    <div class="cart-item">
        <input type="checkbox" name="selectedItems[]" value="{{ $item->id }}">
        <div class="cart-item-image">
            <img src="{{ asset('images/' . $item->image) }}" alt="Product Image" width="70">
        </div>
        <div class="cart-item-details">
            <input type="hidden" name="productId" value="{{ $item->productId }}">
            <h3>{{ $item->productName }}</h3>
            <h4>{{ $item->category }}</h4>
            <p class="item-price">₱{{ number_format($item->price, 2) }}</p>
            <div class="quantity-controls">
                <input type="number" name="quantity" value="{{ $item->quantity }}" 
                       min="1" max="{{ $item->stock }}" class="quantity-input">
            </div>
            <button class="btn btn-danger" onclick="removeFromCart({{ $item->id }}, event)">Remove</button>
        </div>
    </div>
@endforeach
