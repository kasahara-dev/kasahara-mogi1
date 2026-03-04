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
        <div class="messages--area" id="messagesArea">
            @foreach ($messages as $message)
                @if($message->user_id==Auth::id())
                    <div class="message--area__mine">
                        <div class="message-header--area__mine">
                            <div class="message-header--name">{{ Auth::user()->name }}</div>
                            <img src="{{ asset(Auth::user()->profile->img_path) }}" class="message-header--icon" />
                        </div>
                        @if($message->img_path)
                            <img class="message--img" src="{{ asset($message->img_path) }}" alt="コメント画像">
                        @endif
                        <form class="message-edit--form" action="/message/{{ $message->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea name="message[{{ $message->id }}]" class="message--detail__edit">{{ old('message.'.$message->id,$message->detail) }}</textarea>
                            <div class="message-edit--area">
                                @if($errors->has("message." . $message->id))
                                    {{  $errors->first("message." . $message->id) }}
                                @endif
                                <button type="submit" class="message-edit--btn">編集</button>
                            </form>
                            <form action="/message/{{ $message->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="message-edit--btn">削除</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="message--area__target">
                        <div class="message-header--area__target">
                            <img src="{{ asset($message->user->profile->img_path) }}" class="message-header--icon" />
                            <div class="message-header--name">{{ $message->user->name }}</div>
                        </div>
                        @if($message->img_path)
                            <img class="message--img" src="{{ asset($message->img_path) }}" alt="コメント画像">
                        @endif
                        <div class="message--detail">{{ $message->detail }}</div>
                    </div>
                @endif
            @endforeach
            <div class="message-input--area">input</div>
        </div>
    </div>
</div>
<script src={{ asset('/js/messages.js') }}></script>
@endsection