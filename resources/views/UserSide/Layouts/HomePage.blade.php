<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .layout-container {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 20px;
        padding: 20px;
    }

    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .sidebar-box {
        background: #f5f5f5;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 15px;
        margin-bottom: 20px;
    }

    .sidebar-title {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
        border-bottom: 2px solid #FF6B35;
        padding-bottom: 8px;
    }

    .category-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border-bottom: 1px solid #eee;
        transition: all 0.3s ease;
    }

    .category-item:last-child {
        border-bottom: none;
    }

    .category-item:hover {
        background-color: #fff1e9;
        border-radius: 6px;
    }

    .category-icon {
        width: 24px;
        height: 24px;
        margin-right: 12px;
        color: #FF6B35;
    }

    .category-link {
        flex-grow: 1;
        color: #333;
        text-decoration: none;
        font-size: 15px;
    }

    .category-count {
        background: #FF6B35;
        color: white;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 12px;
        min-width: 30px;
        text-align: center;
    }

    .featured-product {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        transition: all 0.3s ease;
    }

    .featured-product:last-child {
        border-bottom: none;
    }

    .featured-product:hover {
        transform: translateX(5px);
    }

    .featured-product img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 10px;
    }

    .featured-product-details {
        flex-grow: 1;
    }

    .featured-product-name {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .featured-product-price {
        color: #FF6B35;
        font-weight: bold;
    }

    .main-carousel {
        position: relative;
        height: 400px;
        background: #f5f5f5;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .carousel-container {
        width: 100%;
        height: 100%;
    }

    .carousel-slides {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }


    .bottom-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 20px;
    }

    .grid-item {
        background: #f5f5f5;
        height: 200px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease;
    }

    .grid-item:hover {
        transform: translateY(-5px);
    }

    .grid-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .grid-item-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 10px;
        text-align: center;
    }

    .products-section {
        margin-top: 40px;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        padding: 20px 0;
    }

    .product-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        height: auto;
        position: relative;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);

    }

    .product-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-details {
        padding: 12px;
        position: relative;
    }

    .product-name {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-category {
        color: #666;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .product-price {
        color: #FF6B35;
        font-weight: 500;
        font-size: 14px;
        margin-top: 1rem;
        margin-bottom: 0;
        display: inline-block;
    }

    .add-to-cart-btn {
        background: #FF6B35;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 15px;
        float: right;
        transition: all 0.3s ease;
    }

    .product-card:hover .add-to-cart-btn {
        background: #ff5722;
    }

    .product-details::after {
        content: '';
        display: table;
        clear: both;
    }
</style>

<body>
    @include('UserSide.Pages.HeaderPage')

    <div class="layout-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Categories Box -->
            <div class="sidebar-box">
                <h3 class="sidebar-title">Categories</h3>
                <?php
                $categories = DB::table('products')->select('category', DB::raw('count(*) as count'))->groupBy('category')->orderBy('category')->get();
                ?>

                @foreach ($categories as $category)
                    <div class="category-item">
                        <i class="bi bi-box category-icon"></i>
                        <a href="{{ route('MainPage') }}" class="category-link">
                            {{ $category->category }}
                        </a>
                        <span class="category-count">
                            {{ $category->count }}
                        </span>
                    </div>
                @endforeach
            </div>

            <!-- Featured Products Box -->
            <div class="sidebar-box">
                <h3 class="sidebar-title">Featured Products</h3>
                <?php
                $featuredProducts = DB::table('products')->orderBy('created_at', 'desc')->take(10)->get();
                ?>

                @foreach ($featuredProducts as $product)
                    <div class="featured-product">
                        <img src="{{ asset('/images/' . $product->image) }}" alt="{{ $product->productName }}"
                            onerror="this.src='{{ asset('assets/default-product.png') }}'">
                        <div class="featured-product-details">
                            <div class="featured-product-name">{{ $product->productName }}</div>
                            <div class="featured-product-price">₱{{ number_format($product->price, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Carousel -->
            <div class="main-carousel">
                <div class="carousel-container">
                    <div class="carousel-slides" id="carouselSlides">
                        <video autoplay muted controls loop playsinline>
                            <source
                                src="{{ asset('assets/Video/Ecommerce Promotions - Motion Graphic Animation..mp4') }}"
                                type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>

            <!-- Bottom Grid -->
            <div class="bottom-grid">
                <div class="grid-item">
                    <img src="{{ asset('assets/category1.jpg') }}" alt="Category 1">
                    <div class="grid-item-overlay">
                        <h3>New Arrivals</h3>
                    </div>
                </div>
                <div class="grid-item">
                    <img src="{{ asset('assets/category2.jpg') }}" alt="Category 2">
                    <div class="grid-item-overlay">
                        <h3>Best Sellers</h3>
                    </div>
                </div>
                <div class="grid-item">
                    <img src="{{ asset('assets/category3.jpg') }}" alt="Category 3">
                    <div class="grid-item-overlay">
                        <h3>Special Offers</h3>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="products-section">
                <div class="products-grid">
                    <?php
                    $products = DB::table('products')->get();
                    ?>
                    @foreach ($products->take(15) as $product)
                        <div class="product-card">
                            <img src="{{ asset('/images/' . $product->image) }}" alt="{{ $product->productName }}"
                                class="product-image" onerror="this.src='{{ asset('assets/default-product.png') }}'">
                            <div class="product-details">
                                <h3 class="product-name">{{ $product->productName }}</h3>
                                <p class="product-category">{{ $product->category }}</p>
                                <label for="" style="font-size: .80rem;">
                                    @if (floatval($product->stock) >= 50)
                                        ⭐⭐⭐⭐⭐
                                    @elseif (floatval($product->stock) > 40)
                                        ⭐⭐⭐⭐
                                    @elseif (floatval($product->stock) > 30)
                                        ⭐⭐⭐
                                    @elseif(floatval($product->stock) > 20)
                                        ⭐⭐
                                    @else
                                        ⭐
                                    @endif
                                </label>
                                <div>
                                    <p class="product-price">₱{{ number_format($product->price, 2) }}</p>
                                    <a href="{{ route('MainPage') }}">
                                        <button type="submit" class="add-to-cart-btn">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</body>

</html>
