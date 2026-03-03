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
                @csrf
                <input type="hidden" name="from" value="header" />
                <button type="submit" class="profile-edit-btn">プロフィールを編集</button>
            </form>
        </div>
    </div>
    <div class="tab-titles">
        @if ($page == 'buy')
            <a href="/mypage?page=sell" class="tab-inactive">出品した商品</a>
            <a href="/mypage?page=buy" class="tab-active">購入した商品</a>
            <a href="/mypage?page=in-progress" class="tab-inactive">取引中の商品@if($messages_count>0)<span class="tab-badge">{{ $messages_count }}</span>@endif</a>
        @elseif($page == 'in-progress')
            <a href="/mypage?page=sell" class="tab-inactive">出品した商品</a>
            <a href="/mypage?page=buy" class="tab-inactive">購入した商品</a>
            <a href="/mypage?page=in-progress" class="tab-active">取引中の商品@if($messages_count>0)<span class="tab-badge">{{ $messages_count }}</span>@endif</a>
        @else
            <a href="/mypage?page=sell" class="tab-active">出品した商品</a>
            <a href="/mypage?page=buy" class="tab-inactive">購入した商品</a>
            <a href="/mypage?page=in-progress" class="tab-inactive">取引中の商品@if($messages_count>0)<span class="tab-badge">{{ $messages_count }}</span>@endif</a>
        @endif
    </div>
    <div class="items-area">
        @if(!is_null($items))
            @foreach ($items as $item)
                <div class="item-area">
                    <a href="/item/{{ $item->id }}" class="item-link">
                        <img title="{{ $item->detail }}" src="{{ asset($item->img_path) }}" alt="{{ $item->name }}"
                            class="item-image" name="{{ $item->id }}" />
                        @if (($page != 'buy') and ($page != 'in-progress') and isset($item->purchase))
                            <div class="item-sold">
                                <p class="item-sold-msg">Sold</p>
                            </div>
                        @endif
                        @if($page == 'in-progress' and isset($item->purchase->messages) and $item->purchase->unreadMessagesCount() > 0)
                            <div class="item-badge-area">
                                <p class="item-badge">{{ $item->purchase->unreadMessagesCount() }}</p>
                            </div>
                        @endif
                        <label for="{{ $item->id }}" class="item-name">{{ $item->name }}</label>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
@endsection