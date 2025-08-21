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
                @auth
                    @if($favorite)
                        <form id="favorite-form" action="/item/{{ $item_id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="favorite" id="favorite" value="{{ $item_id }}" />
                            <div class="icon-area"><img class="item-icon fav-icon" id="fav-icon" name="fav-icon" alt="お気に入りアイコン"
                                    src="{{ asset('img/star-solid-full.svg') }}" onclick="destroyFavorite()" />
                                <label for="fav-icon" class="icon-count fav-count">{{ $favUsersCount }}</label>
                            </div>
                        </form>
                    @else
                        <form id="favorite-form" action="/item/{{ $item_id }}" method="POST">
                            @csrf
                            <input type="hidden" name="favorite" id="favorite" value="{{ $item_id }}" />
                            <div class="icon-area"><img class="item-icon fav-icon" id="fav-icon" name="fav-icon" alt="お気に入りアイコン"
                                    src="{{ asset('img/star-regular-full.svg') }}" onclick="storeFavorite()">
                                <label for="fav-icon" class="icon-count fav-count">{{ $favUsersCount }}</label>
                            </div>
                        </form>
                    @endif
                @endauth
                @guest
                    <div c  lass="icon-area"><img class="item-icon" name="fav-icon" alt="お気に入りアイコン"
                            src="{{ asset('img/star-regular-full.svg') }}">
                        <label class="icon-count">{{ $favUsersCount }}</label>
                    </div>
                @endguest
                <div class="icon-area"><img class="item-icon" alt="コメントアイコン"
                        src="{{ asset('img/comment-regular-full.svg') }}">
                    <div class="icon-count">{{ $commentsCount }}</div>
                </div>
            </div>
            @auth
                @if (isset($item->purchase))
                    <button class="wide-btn inactive-btn">購入手続きへ</button>
                @else
                    <button onclick="location.href=''" class="wide-btn">購入手続きへ</button>
                @endif
            @endauth
            @guest
                <button class="wide-btn inactive-btn">購入手続きへ</button>
            @endguest
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
                    <div class="comment-user-area">
                        <img class="comment-user-icon" src='{{ asset($comment->user->profile->img_path) }}'>
                        </img>
                        {{ $comment->user->name }}
                    </div>
                    <div class="comment-detail">{{ $comment->detail }}</div>
                @endforeach
            </div>
            <form action="/item/{{ $item->id }}" class="comment-form" method="POST">
                @csrf
                <label for="comment-input" class="comment-info">商品へのコメント</label>
                <textarea name="commentInput" class="comment-input">{{ old('commentInput') }}</textarea>
                <div class="form-error">
                    @error('commentInput')
                        {{ $message }}
                    @enderror
                </div>
                @auth
                    @if (isset($item->purchase))
                        <button class="wide-btn inactive-btn">コメントを送信する</button>
                    @else
                        <input type="hidden" value="{{ $item_id }}" name="itemId" />
                        <button type="submit" class="wide-btn" name="send-comment">コメントを送信する</button>
                    @endif
                @endauth
            </form>
            @guest
                <button class="wide-btn inactive-btn">コメントを送信する</button>
            @endguest
        </div>
    </div>
    <script src="{{ asset('/js/favorite.js') }}"></script>
@endsection