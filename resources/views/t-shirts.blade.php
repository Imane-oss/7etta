@extends('layout')

@section('title', '7ETTA - T-Shirts')

@push('styles')
    @vite('resources/css/index.css')
@endpush

@section('content')
    <div class="promo-banner">
        <img src="{{ asset('images/banner.png') }}" alt="T-Shirts Collection">
        <div class="promo-content">
            <h2>{{ $category?->name ?? 'T-Shirts Collection' }}</h2>
            <a href="#tshirts-products" class="btn">SHOP NOW</a>
        </div>
    </div>

    <div class="info-section text-center">
        <h2>{{ $category?->name ?? 'T-Shirts' }}</h2>
        <p>
            Découvrez notre sélection de t-shirts 7ETTA, pensée pour un look premium,
            des coupes nettes et un confort facile à porter tous les jours.
        </p>
    </div>

    <div class="container my-5" id="tshirts-products">
        @if ($products->count() > 0)
            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-4 col-6">
                        <x-product-card
                            :imageDefault="$product->image_url ?: 'images/ted.png'"
                            :imageHover="$product->image_hover_url ?: 'images/fig.png'"
                            :title="$product->name_product"
                            :price="number_format((float) $product->price, 2) . ' dh'"
                            :soldOut="$product->stock_quantity <= 0"
                            soldOutText="ÉPUISÉ"
                            :slug="$product->slug"
                        />
                    </div>
                @endforeach
            </div>

            @if (method_exists($products, 'links'))
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->links() }}
                </div>
            @endif
        @elseif ($category)
            <div class="text-center py-5">
                <h2 class="h4 mb-3">Aucun t-shirt disponible</h2>
                <p class="text-muted mb-0">
                    Les produits t-shirts apparaîtront ici dès qu'ils seront ajoutés.
                </p>
            </div>
        @else
            <div class="text-center py-5">
                <h2 class="h4 mb-3">Catégorie introuvable</h2>
                <p class="text-muted mb-0">
                    La catégorie "{{ $categoryName }}" n'a pas été trouvée.
                </p>
            </div>
        @endif
    </div>
@endsection
