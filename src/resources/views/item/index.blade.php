@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header')
    @parent
    @guest
        <form action="/" method="get" class="header-form">
            @csrf
            <input type="search" value="{{ $keyword }}" name="search" placeholder="なにをお探しですか?" class="header-search">
        </form>
        <ul class="header-btns">
            <li class="header-btn"><a href="/login" class="header-login">ログイン</a></li>
            <li class="header-btn"><a href="/mypage" class="header-mypage">マイページ</a></li>
            <li class="header-btn"><button onclick="location.href='/sell'" class="header-exhibit">出品</button></li>
        </ul>
    @endguest
@endsection

@section('content')
    <div class="tab-titles">
        @if ($myList == true)
            <a href="/" class="tab-inactive">おすすめ</a>
            <a href="/?tab=mylist" class="tab-active">マイリスト</a>
        @else
            <a href="/" class="tab-active">おすすめ</a>
            <a href="/?tab=mylist" class="tab-inactive">マイリスト</a>
        @endif
    </div>
    <div class="items-area">
        @foreach ($items as $item)
            <div class="item-area">
                <img title="{{ $item->detail }}" src="{{ $item->img_path }}" alt="{{ $item->name }}" class="item-image"
                    name="{{ $item->id }}" />
                @if (isset($item->purchase))
                    <div class="item-sold">
                        <p class="item-sold-msg">SOLD</p>
                    </div>
                @endif
                <label for="{{ $item->id }}" class="item-name">{{ $item->name }}</label>
            </div>
        @endforeach
    </div>
@endsection