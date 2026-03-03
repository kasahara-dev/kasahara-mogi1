@extends('layout.noitem')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/message.css') }}">
@endsection

@section('content')
<div class="contents--area">
    <div class="other-list--area">
        <h2 class="other-list--title">その他の取引</h2>
    </div>
    <div class="details--area">
        <div class="title--area">
            <div class="targe-user--area">
                <img class="img--area" src="{{ asset($target_user->profile->img_path) }}" alt="取引相手アイコン" />
                <h1 class="title">{{ $target_user->name }}さんとの取引画面</h1>
            </div>
            <div class="commit-btn"></div>
        </div>
    </div>
</div>
@endsection