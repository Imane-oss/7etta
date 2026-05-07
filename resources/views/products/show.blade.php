@extends('layout')

@section('title', $product->name_product . ' - 7ETTA')

@push('styles')
    @vite(['resources/css/product-show.css', 'resources/css/index.css'])
@endpush
@push('scripts')
    @vite('resources/js/show.js')
@endpush

@section('content')
    <div class="product-detail">
        <div class="container">
            <!-- Breadcrumb -->
            <div class="product-breadcrumb">
                <a href="{{ route('home') }}">Home</a> /
                @if($product->category)
                    <a href="/{{ \Illuminate\Support\Str::lower(\Illuminate\Support\Str::replace(' ', '-', $product->category->name)) }}">{{ $product->category->name }}</a> /
                @endif
                <span>{{ $product->name_product }}</span>
            </div>

            <div class="row">
                <!-- LEFT: Product Gallery -->
                <div class="col-md-6">
                    <div class="product-gallery">
                        <div class="product-main-image" id="productZoomContainer">
                            <img id="productMainImg" src="{{ \Illuminate\Support\Str::startsWith($product->image_url, ['http://', 'https://']) ? $product->image_url : asset($product->image_url) }}" alt="{{ $product->name_product }}">
                        </div>

                        <div class="product-thumbs">
                            <img src="{{ \Illuminate\Support\Str::startsWith($product->image_url, ['http://', 'https://']) ? $product->image_url : asset($product->image_url) }}" alt="Thumbnail" class="active" onclick="switchImage(this)">
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Product Info -->
                <div class="col-md-6">
                    <div class="product-info">
                        <h1 class="product-detail-title">{{ $product->name_product }}</h1>

                        <div class="product-detail-price">{{ number_format($product->price, 2) }} dh</div>

                        <!-- Stock Status -->
                        @if($product->stock_quantity > 0)
                            <div class="stock-badge in-stock">
                                <span class="stock-dot"></span>
                                En stock ({{ $product->stock_quantity }})
                            </div>
                        @else
                            <div class="stock-badge out-of-stock">
                                <span class="stock-dot"></span>
                                Épuisé
                            </div>
                        @endif

                        <!-- Description -->
                        @if($product->description)
                            <p class="product-detail-description">{{ $product->description }}</p>
                        @else
                            <p class="product-detail-description">Premium streetwear designed for bold style and comfort.</p>
                        @endif

                        <!-- Size Selector -->
                        @if(count($product->available_sizes) > 0)
                            <div class="option-group">
                                <span class="option-label">Size</span>
                                <div class="size-options">
                                    @foreach($product->available_sizes as $size)
                                        <button type="button" class="size-btn" onclick="selectSize(this)">{{ $size }}</button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Color Selector -->
                        @if(count($product->available_colors) > 0)
                            <div class="option-group">
                                <span class="option-label">Color</span>
                                <div class="color-options">
                                    @foreach($product->available_colors as $color)
                                        <div class="color-swatch" style="background-color: {{ $color }};" onclick="selectColor(this)" title="{{ $color }}"></div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="size" id="selectedSize">
                            <input type="hidden" name="color" id="selectedColor">
                            
                            <button type="submit" class="add-to-cart-btn" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                {{ $product->stock_quantity > 0 ? 'ADD TO CART' : 'OUT OF STOCK' }}
                            </button>
                        </form>

                        <!-- Product Meta -->
                        <div class="product-meta">
                            @if($product->category)
                                <div class="product-meta-item">
                                    <i class="bi bi-tag"></i>
                                    Category: {{ $product->category->name }}
                                </div>
                            @endif
                            <div class="product-meta-item">
                                <i class="bi bi-truck"></i>
                                Free shipping on orders over 500 dh
                            </div>
                            <div class="product-meta-item">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                Easy returns within 14 days
                            </div>
                            <div class="product-meta-item">
                                <i class="bi bi-shield-check"></i>
                                Secure payment guaranteed
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== RELATED PRODUCTS ===== -->
    @if($relatedProducts->count() > 0)
        <div class="related-section">
            <div class="container">
                <h2 class="related-section-title">You Might Also Like</h2>
                <div class="row g-4">
                    @foreach($relatedProducts as $related)
                        <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                            <x-product-card
                                :imageDefault="$related->image_url ?? 'images/shoes.png'"
                                :imageHover="$related->image_hover_url ?? 'images/fig.png'"
                                :title="$related->name_product"
                                :price="$related->price . ' dh'"
                                :soldOut="$related->stock_quantity <= 0"
                                :soldOutText="'ÉPUISÉ'"
                                :slug="$related->slug"
                            />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        // Image zoom on hover
        const zoomContainer = document.getElementById('productZoomContainer');
        const mainImg = document.getElementById('productMainImg');

        if (zoomContainer && mainImg) {
            zoomContainer.addEventListener('mousemove', (e) => {
                const { left, top, width, height } = zoomContainer.getBoundingClientRect();
                const x = ((e.clientX - left) / width) * 100;
                const y = ((e.clientY - top) / height) * 100;
                mainImg.style.transformOrigin = `${x}% ${y}%`;
                mainImg.style.transform = 'scale(2.5)';
            });

            zoomContainer.addEventListener('mouseleave', () => {
                mainImg.style.transform = 'scale(1)';
                mainImg.style.transformOrigin = 'center center';
            });
        }

        // Switch thumbnail image
        function switchImage(el) {
            mainImg.src = el.src;
            document.querySelectorAll('.product-thumbs img').forEach(img => img.classList.remove('active'));
            el.classList.add('active');
        }

        // Size selector
        function selectSize(el) {
            document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('selectedSize').value = el.innerText;
        }

        // Color selector
        function selectColor(el) {
            document.querySelectorAll('.color-swatch').forEach(swatch => swatch.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('selectedColor').value = el.getAttribute('title');
        }
    </script>
@endpush


