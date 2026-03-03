@extends('layout.noitem')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/message.css') }}">
@endsection

@section('content')
<div class="contents--area">
    <div class="other-list--area">
        <h2 class="other-list--title">その他の取引</h2>
        @foreach ($other_items as $other_item)
            <a href="/message/{{ $other_item->purchase->id }}" class="other-list--link">{{ $other_item->name }}</a>
        @endforeach
    </div>
    <div class="details--area">
        <div class="title--area">
            <div class="targe-user--area">
                <img class="img--area" src="{{ asset($target_user->profile->img_path) }}" alt="取引相手アイコン" />
                <h1 class="title">{{ $target_user->name }}さんとの取引画面</h1>
            </div>
            <div class="commit-btn--area">
                @if($purchaser)
                    <form action="/message/{{ $purchase->id }}" method="post">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="commit-btn">取引を完了する</button>
                    </form>
                @endif
            </div>
        </div>
        <div class="item--area">
            <img class="item--img" src="{{ asset($purchase->item->img_path) }}" alt="商品画像">
            <div class="item--info">
                <div class="item--name">{{ $purchase->item->name }}</div>
                <div class="item--price">￥{{ number_format($purchase->item->price) }}</div>
            </div>
        </div>
    </div>
</div>
@endsection