@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <div class="contents-area">
        <div class="image-area">
            <img src="{{ asset($item->img_path) }}" alt='商品画像' class="item-img" />
            @if (isset($item->purchase))
                <div class="item-sold">
                    <p class="item-sold-msg">SOLD</p>
                </div>
            @endif
        </div>
        <div class="intro-area">
            <h2 class="item-name">{{ $item->name }}</h2>
            <div class="brand-name">{{ $item->brand }}</div>
            <div class="price-area">&yen;<span class="price">{{ number_format($item->price) }}</span>(税込)</div>
            <div class="icons-area"><img class="item-icon" alt="お気に入りアイコン" src="{{ asset('img/star-regular-full.svg') }}"></div>
        </div>
    </div>
@endsection