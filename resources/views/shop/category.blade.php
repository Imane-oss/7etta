@extends('layout')

@section('title', '7ETTA - ' . $categoryName)

@push('styles')
    @vite('resources/css/index.css')
@endpush

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <p class="text-uppercase text-muted mb-2">Collection</p>
                <h1 class="section-title mb-3">{{ $category?->name ?? $categoryName }}</h1>

                @if ($category)
                    <p class="mx-auto" style="max-width: 640px;">
                        Découvrez nos derniers articles {{ strtolower($category->name) }} avec le style premium 7ETTA.
                    </p>
                @else
                    <p class="mx-auto text-muted" style="max-width: 640px;">
                        Cette catégorie n'existe pas encore dans la base de données.
                    </p>
                @endif
            </div>

            @if ($category && $products->count() > 0)
                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-6 col-md-4 col-xl-3">
                            <x-product-card
                                :imageDefault="$product->image_url ?: 'images/ted.png'"
                                :imageHover="$product->image_url ?: 'images/fig.png'"
                                :title="$product->name_product"
                                :price="number_format((float) $product->price, 2) . ' dh'"
                                :soldOut="$product->stock_quantity <= 0"
                                soldOutText="ÉPUISÉ"
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
                    <h2 class="h4 mb-3">Aucun produit disponible</h2>
                    <p class="text-muted mb-0">
                        Cette catégorie est prête, mais aucun article n'y a encore été ajouté.
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
    </section>
@endsection
