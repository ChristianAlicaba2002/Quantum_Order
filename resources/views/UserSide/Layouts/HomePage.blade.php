<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    @include('UserSide.Pages.HeaderPage')
    <div class="layout-container">
        <div class="sidebar">
            <div class="sidebar-box">
                <h3 class="sidebar-title">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                    Categories
                </h3>
                <div class="category-list">
                    @php
                        $categories = DB::table('products')
                            ->select('category', DB::raw('count(*) as count'))
                            ->groupBy('category')
                            ->orderBy('category')
                            ->get();
                    @endphp
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
            </div>

            <div class="sidebar-box">
                <h3 class="sidebar-title">
                    <i class="bi bi-star-fill"></i>
                    Featured Products
                </h3>
                <div class="featured-products-list">
                    @php
                        $featuredProducts = DB::table('products')
                            ->orderBy('created_at', 'desc')
                            ->take(10)
                            ->get();
                    @endphp
                    @foreach ($featuredProducts as $product)
                        <div class="featured-product">
                            <img src="{{ asset('/images/' . $product->image) }}" 
                                alt="{{ $product->productName }}"
                                onerror="this.src='{{ asset('assets/default-product.png') }}'">
                            <div class="featured-product-details">
                                <div class="featured-product-name">{{ $product->productName }}</div>
                                <div class="featured-product-price">₱{{ number_format($product->price, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="main-carousel">
                <video 
                    id="myVideo" 
                    controls 
                    autoplay  
                    loop
                >
                    <source src="{{ asset('assets/Video/EcommerceVideo.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>

            <div class="bottom-grid">
                <div class="grid-item">
                    <img src="{{ asset('assets/category1.jpg') }}" alt="New Arrivals">
                    <div class="grid-item-overlay">
                        <h3>New Arrivals</h3>
                    </div>
                </div>
                <div class="grid-item">
                    <img src="{{ asset('assets/category2.jpg') }}" alt="Best Sellers">
                    <div class="grid-item-overlay">
                        <h3>Best Sellers</h3>
                    </div>
                </div>
                <div class="grid-item">
                    <img src="{{ asset('assets/category3.jpg') }}" alt="Special Offers">
                    <div class="grid-item-overlay">
                        <h3>Special Offers</h3>
                    </div>
                </div>
            </div>

            <div class="products-section">
                <div class="products-grid">
                    @php
                        $products = DB::table('products')->take(12)->get();
                    @endphp
                    @foreach ($products as $product)
                        <div class="product-card">
                            <img src="{{ asset('/images/' . $product->image) }}" 
                                alt="{{ $product->productName }}"
                                class="product-image" 
                                onerror="this.src='{{ asset('assets/default-product.png') }}'">
                            <div class="product-details">
                                <h3 class="product-name">{{ $product->productName }}</h3>
                                <p class="product-category">{{ $product->category }}</p>
                                <div class="product-price" style="color: red;">₱{{ number_format($product->price, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var video = document.getElementById('myVideo');
            
            // Log video load status
            video.addEventListener('loadeddata', function() {
                console.log('Video loaded successfully');
            });
            
            // Log any errors
            video.addEventListener('error', function(e) {
                console.error('Error loading video:', video.error);
                console.error('Video source:', video.currentSrc);
            });
        });
    </script>
</body>

</html>
