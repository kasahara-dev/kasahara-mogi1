@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header')
    @parent
    @guest
        <input type="text" placeholder="なにをお探しですか?" class="header-search">
        <ul class="header-btns">
            <li class="header-btn"><a href="/login" class="header-login">ログイン</a></li>
            <li class="header-btn"><a href="/mypage" class="header-mypage">マイページ</a></li>
            <li class="header-btn"><button onclick="location.href='/sell'" class="header-exhibit">出品</button></li>
        </ul>
    @endguest
@endsection

@section('content')

@endsection