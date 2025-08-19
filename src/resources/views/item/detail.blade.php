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
            <div class="icons-area">
                <div class="icon-area"><img class="item-icon fav-icon" name="fav-icon" alt="お気に入りアイコン"
                        src="{{ asset('img/star-regular-full.svg') }}">
                    <label for="fav-icon" class="icon-count fav-count">{{ $favUsersCount }}</label>
                </div>
                <div class="icon-area"><img class="item-icon" alt="コメントアイコン"
                        src="{{ asset('img/comment-regular-full.svg') }}">
                    <div class="icon-count">{{ $commentsCount }}</div>
                </div>
            </div>
            @if (isset($item->purchase))
                <button class="wide-btn inactive-btn">購入手続きへ</button>
            @else
                <button onclick="location.href=''" class="wide-btn">購入手続きへ</button>
            @endif
            <dl class="info-list">
                <dt class="info-title">商品説明</dt>
                <dd class="info-detail">{{ $item->detail }}</dd>
                <dt class="info-title">商品の情報</dt>
                <dd class="info-detail">
                    <dl class="inner-list">
                        <div class="inner-line">
                            <dt class="inner-title">カテゴリー</dt>
                            <dd class="inner-detail">
                                @foreach ($item->categories as $category)
                                    <div class="category-tag">{{ $category->name }}</div>
                                @endforeach
                            </dd>
                        </div>
                        <div class="inner-line">
                            <dt class="inner-title">商品の状態</dt>
                            <dd class="inner-detail">{{ config('condition')[$item->condition] }}</dd>
                        </div>
                    </dl>
                </dd>
            </dl>
            <div class="comment-title">コメント({{ $commentsCount }})</div>
            <div class="comments-area">
                @foreach ($comments as $comment)
                    <img src=""></img>
                @endforeach
            </div>
        </div>
    </div>
@endsection