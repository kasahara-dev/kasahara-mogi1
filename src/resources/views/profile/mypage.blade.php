@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="user-info-area">
        <div class="user-title">
            <img class="user-img" src="{{ asset(auth()->user()->profile->img_path) }}" alt="ユーザーアイコン" />
            <div class="user-name">{{ auth()->user()->name }}</div>
        </div>
        <div class="user-btn-area">
            <form action="/mypage/profile" method="GET">
                <button type="submit" class="profile-edit-btn">プロフィールを編集</button>
            </form>
        </div>
    </div>
    <div class="tab-titles">
        @if ($tab == 'buy')
            <a href="/mypage?page=sell" class="tab-inactive">出品した商品</a>
            <a href="/mypage?page=buy" class="tab-active">購入した商品</a>
        @else
            <a href="/mypage?page=sell" class="tab-active">出品した商品</a>
            <a href="/mypage?page=buy" class="tab-inactive">購入した商品</a>
        @endif
    </div>
    <div class="items-area">
        @if(!is_null($items))
            @foreach ($items as $item)
                <div class="item-area">
                    <a href="/item/{{ $item->id }}" class="item-link">
                        <img title="{{ $item->detail }}" src="{{ asset($item->img_path) }}" alt="{{ $item->name }}"
                            class="item-image" name="{{ $item->id }}" />
                        @if (($tab != 'buy') and isset($item->purchase))
                            <div class="item-sold">
                                <p class="item-sold-msg">SOLD</p>
                            </div>
                        @endif
                        <label for="{{ $item->id }}" class="item-name">{{ $item->name }}</label>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
@endsection