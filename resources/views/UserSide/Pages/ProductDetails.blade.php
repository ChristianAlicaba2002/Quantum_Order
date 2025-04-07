<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ Auth::user()->firstName }} - Product Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 2% auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #FF6B35;
            text-decoration: none;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .product-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            padding: 20px;
        }

        .product-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .product-info {
            padding: 20px;
        }

        .product-name {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .product-category {
            color: #666;
            font-size: 16px;
            margin-bottom: 20px;
            padding: 5px 10px;
            background: #f0f0f0;
            border-radius: 4px;
            display: inline-block;
        }

        .product-price {
            font-size: 28px;
            color: #FF6B35;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .stock-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .stock-label {
            color: #666;
        }

        .stock-count {
            color: #28a745;
            font-weight: bold;
        }

        .description-box {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .description-title {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .description-text {
            color: #666;
            line-height: 1.6;
        }

        .add-to-cart-section {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-top: 30px;
        }

        .quantity-input {
            width: 100px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .add-to-cart-btn {
            background: #FF6B35;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-to-cart-btn:hover {
            background: #ff5722;
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="{{ route('MainPage') }}" class="back-link">
            <i class="bi bi-arrow-left"></i>
            Back to Products
        </a>

        <div class="product-container">
            <!-- Product Image Section -->
            <div class="image-section">
                <img src="{{ asset('/images/' . $image) }}" alt="{{ $productName }}" class="product-image"
                    onerror="this.src='{{ asset('assets/default-product.png') }}'">
            </div>

            <!-- Product Information Section -->
            <div class="product-info">
                <h1 class="product-name">{{ $productName }}</h1>
                <span class="product-category">{{ $category }}</span>
                <p class="product-price">₱{{ number_format($price, 2) }}</p>

                <div class="stock-info">
                    <span class="stock-label">Available Stock:</span>
                    <span class="stock-count">{{ $stock }} units</span>
                </div>

                <div class="description-box">
                    <h3 class="description-title">Product Description</h3>
                    <p class="description-text">{{ $description }}</p>
                </div>

                <form action="{{ route('addtocart', ['id' => $productId]) }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="productId" value="{{ $productId }}">
                    <input type="hidden" name="productName" value="{{ $productName }}">
                    <input type="hidden" name="category" value="{{ $category }}">
                    <input type="hidden" name="price" value="{{ $price }}">
                    <input type="hidden" name="stock" value="{{ $stock }}">
                    <input type="hidden" name="description" value="{{ $description }}">
                    <input type="hidden" name="image" value="{{ $image }}">
                    <input type="hidden" name="userId" value="{{ Auth::user()->userId }}">
                    <input type="hidden" name="username" value="{{ Auth::user()->username }}">
                    <div class="add-to-cart-section">
                        
                        @if (number_format( $stock ) == 0)
                        <input type="number" name="quantity" id="ChangeQuantity" class="quantity-input" value="0" readonly>
                        <button type="submit" class="add-to-cart-btn" disabled style="cursor:not-allowed">
                            Out of Stock
                        </button>
                        @else
                        <input type="number" name="quantity" id="ChangeQuantity" class="quantity-input" value="1"
                            min="1" max="{{ $stock }}" required>
                        <button type="submit" class="add-to-cart-btn">
                            Add to Cart
                        </button>
                        @endif
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</body>

</html>
