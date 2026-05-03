@props([
    'imageDefault',
    'imageHover' => null,
    'title' => 'Product',
    'price' => null,
    'soldOut' => false,
    'soldOutText' => 'Sold out',
])

@php
    $defaultImage = \Illuminate\Support\Str::startsWith($imageDefault, ['http://', 'https://'])
        ? $imageDefault
        : asset($imageDefault);

    $hoverImage = $imageHover
        ? (\Illuminate\Support\Str::startsWith($imageHover, ['http://', 'https://']) ? $imageHover : asset($imageHover))
        : null;
@endphp

<div class="product-card">
    <div class="product-image">
        <img src="{{ $defaultImage }}" class="img-default" alt="{{ $title }}">

        @if($hoverImage)
            <img src="{{ $hoverImage }}" class="img-hover" alt="{{ $title }}">
        @endif

        @if($soldOut)
            <span class="sold-out">{{ $soldOutText }}</span>
        @endif
    </div>

    <p class="title">{{ $title }}</p>

    @if($price)
        <p class="price">{{ $price }}</p>
    @endif
</div>
