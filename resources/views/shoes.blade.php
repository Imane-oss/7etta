@extends('layout')

@section('title', '7ETTA - Shoes')

@push('styles')
    @vite('resources/css/index.css')
@endpush

@section('content')
    <div class="promo-banner">
        <img src="{{ asset('images/banner.png') }}" alt="Shoes Collection">
        <div class="promo-content">
            <h2>{{ $category?->name ?? 'Shoes Collection' }}</h2>
            <a href="#shoes-products" class="btn">SHOP NOW</a>
        </div>
    </div>

    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <p class="text-uppercase text-muted mb-2">Footwear</p>
                <h1 class="section-title mb-3">{{ $category?->name ?? 'Shoes' }}</h1>

                <p class="mx-auto" style="max-width: 640px;">
                    Explorez notre sélection de shoes 7ETTA avec une présence streetwear affirmée,
                    des lignes propres et un confort prêt pour chaque sortie.
                </p>
            </div>

            <div id="shoes-products">
                @if ($products->count() > 0)
                    <div class="row g-4">
                        @foreach ($products as $product)
                            <div class="col-6 col-md-4 col-xl-3">
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
                        <h2 class="h4 mb-3">Aucune chaussure disponible</h2>
                        <p class="text-muted mb-0">
                            Les produits shoes apparaîtront ici dès qu'ils seront ajoutés.
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
        </div>
    </section>
@endsection
