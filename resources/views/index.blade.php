@extends('layout')

@section('title', '7ETTA - Where Luxury Meets Lifestyle')

@push('styles')
    @vite('resources/css/index.css')
@endpush

@push('scripts')
    @vite('resources/js/app.js')
@endpush


@section('content')
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/ted.png') }}" class="d-block w-100" alt="mkynch tswira">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/fig.png') }}" class="d-block w-100" alt="ml9itx fig">
            </div>
        </div>
    </div>

    <!-- ===== FEATURED PRODUCT ===== -->
    <div class="product-showcase container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="main-image">
                    <img id="mainProductImage" src="{{ asset('images/jlaba1.png') }}" alt="Main Product">
                </div>
            </div>

            <div class="col-md-6">
                <h2 class="product-title">7ETTA Graphic T-Shirt</h2>
                <div class="price">850 dh</div>

                <select class="form-select mb-3">
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                </select>

                <button class="btn btn-dark w-100">ADD TO CART</button>

                <p class="mt-4 text-muted">
                    Premium streetwear t-shirt designed for bold style and comfort.
                </p>

                <div class="thumbs mt-3" id="zoomBox">
                    <img src="{{ asset('images/jlaba1.png') }}" onclick="changeImage(this)" alt="Thumb 1">
                    <img src="{{ asset('images/jlaba2.png') }}" onclick="changeImage(this)" alt="Thumb 2">
                    <img src="{{ asset('images/jlaba3.png') }}" onclick="changeImage(this)" alt="Thumb 3">
                    <img src="{{ asset('images/jlaba4.png') }}" onclick="changeImage(this)" alt="Thumb 4">
                </div>
            </div>
        </div>
    </div>

    <!-- ===== PROMO BANNER ===== -->
    <div class="promo-banner">
        <img src="{{ asset('images/banner.png') }}" alt="Promo Banner">
        <div class="promo-content">
            <h2>STREETWEAR COLLECTION</h2>
            <a href="#" class="btn">SHOP NOW</a>
        </div>
    </div>

    <!-- ===== INFO SECTION ===== -->
    <div class="info-section text-center">
        <h2>Best Sellers</h2>
        <p>
            Browse and discover original branded clothing items,
            delivered directly to your home wherever you are!
        </p>
        <a href="#" class="btn-outline-dark-custom">SHOP NOW</a>
    </div>

    <!-- ===== DYNAMIC PRODUCT GRID ===== -->
    <div class="container my-5">
        <div class="row g-4">
            @forelse($featuredProducts->take(4) as $product)
                <div class="col-lg-3 col-md-6 col-6">
                    <x-product-card :imageDefault="$product->image_url ?? 'images/shoes.png'" :imageHover="$product->image_hover_url ?? 'images/fig.png'" :title="$product->name_product" :price="$product->price . ' dh'"
                        :soldOut="$product->stock_quantity <= 0" :soldOutText="'ÉPUISÉ'" :slug="$product->slug" />
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No products available</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ===== SPECIAL DISPLAY ===== -->
    <div class="container my-5">
        <div class="row g-4">
            <!-- LEFT (ZOOM) -->
            <div class="col-md-6">
                <div class="zoom-card">
                    <img src="{{ asset('images/ted.png') }}" alt="Zoom Display">
                </div>
            </div>

            <!-- RIGHT (SWAP IMAGE) -->
            <div class="col-md-6">
                <div class="swap-card">
                    <img src="{{ asset('images/ted.png') }}" class="img-default" alt="Default">
                    <img src="{{ asset('images/fig.png') }}" class="img-hover" alt="Hover">
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MORE PRODUCTS ===== -->
    @if($featuredProducts->skip(4)->count() > 0)
        <div class="container my-5">
            <div class="row g-4">
                @foreach($featuredProducts->skip(4)->take(12) as $product)
                    <div class="col-lg-3 col-md-4 col-6">
                        <x-product-card
                            :imageDefault="$product->image_url ?? 'images/shoes.png'"
                            :imageHover="$product->image_hover_url ?? 'images/fig.png'"
                            :title="$product->name_product"
                            :price="$product->price . ' dh'"
                            :soldOut="$product->stock_quantity <= 0"
                            :soldOutText="'ÉPUISÉ'"
                            :slug="$product->slug"
                        />
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endsection