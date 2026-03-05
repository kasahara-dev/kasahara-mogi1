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
        @if($purchase->status == 1)
            <div class="modal--area">
                <div class="rate--box">
                    @if($purchase->reviewed())
                        <div class="rate-title--area">取引が完了しました。</div>
                        <div class="rate-select--area">評価済みです</div>
                        <div class="rate-submit--area">
                            <button disabled class="rate-submit--btn">送信する</button>
                        </div>
                    @else
                        <form action="/review/{{ $purchase->id }}" method="POST" class="rate-form">
                            <div class="rate-title--area">取引が完了しました。</div>
                            <div class="rate-select--area">
                                <div class="rate-select--msg">今回の取引相手はどうでしたか？</div>
                                <div class="rate-select-radio--area">
                                    @foreach (config('rate') as $key => $value)
                                        <input type="radio" name="rate" id="rate{{ $key }}" value="{{ $value }}" @if($value == count(config('rate'))) checked @endif class="rate-select-radio"/>
                                        <label for="rate{{ $key }}" id="label{{ $key }}" class="rate-select--star__active">&#9733</label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="rate-submit--area">
                                <button class="rate-submit--btn">送信する</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        @endif
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
                        <button @if($purchase->status == 1) disabled @endif type="submit" class="commit-btn">取引を完了する</button>
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
        @if($purchase->status == 1)
            <div class="messages--area scroll-stop" id="messagesArea">
        @else
            <div class="messages--area" id="messagesArea">
        @endif
            @foreach ($messages as $message)
                @if($message->user_id==Auth::id())
                    <div class="message--area__mine">
                        <div class="message-header--area__mine">
                            <div class="message-header--name">{{ Auth::user()->name }}</div>
                            <img src="{{ asset(Auth::user()->profile->img_path) }}" class="message-header--icon"/>
                        </div>
                        @if($message->img_path)
                            <img class="message--img" src="{{ asset($message->img_path) }}" alt="コメント画像">
                        @endif
                        <form class="message-edit--form" action="/message/{{ $purchase->id }}?message_id={{ $message->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <textarea @if($purchase->status == 1) disabled @endif name="message[{{ $message->id }}]" class="message--detail__edit">{{ old('message.'.$message->id,$message->detail) }}</textarea>
                            <div class="message-edit--area">
                                <div class="error-msg">
                                    @if($errors->has("message." . $message->id))
                                        {{  $errors->first("message." . $message->id) }}
                                    @endif
                                </div>
                                <button @if($purchase->status == 1) disabled @endif type="submit" class="message-edit--btn" @if($errors->has("message." . $message->id)) autofocus @endif>編集</button>
                            </form>
                            <form action="/message/{{ $purchase->id }}?message_id={{ $message->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button @if($purchase->status == 1) disabled @endif type="submit" class="message-edit--btn">削除</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="message--area__target">
                        <div class="message-header--area__target">
                            <img src="{{ asset($message->user->profile->img_path) }}" class="message-header--icon"/>
                            <div class="message-header--name">{{ $message->user->name }}</div>
                        </div>
                        @if($message->img_path)
                            <img class="message--img" src="{{ asset($message->img_path) }}" alt="コメント画像">
                        @endif
                        <div class="message--detail">{{ $message->detail }}</div>
                    </div>
                @endif
            @endforeach
            <div class="new-message--area">
                <div class="error-msg">
                    @error('new_message_text')
                        {{ $message }}
                    @enderror
                    @error('message_img_input')
                        {{ $message }}
                    @enderror
                </div>
                <form class="message-input--area" action="/message/{{ $purchase->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input @if($purchase->status == 1) disabled @endif type="text" name="new_message_text" class="message-input" placeholder="取引メッセージを記入してください" id="new_message_text" value="{{ old("new_message_text") }}"/>
                    <input id="fileElem" name="message_img_input" type="file" class="message-img-input" />
                    <button @if($purchase->status == 1) disabled @endif id="fileSelect" type="button" class="message-input-img--btn">画像を追加</button>
                    <button @if($purchase->status == 1) disabled @endif type="submit" class="send-btn" name="new-message-btn" id="send_btn"><img class="send-btn-img" src="{{ asset('img/send-btn.jpg') }}" alt=""></button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const purchaseId = {{ $purchase->id }};
    const rateConfig = @json(config('rate'));
</script>
<script src={{ asset('js/messages.js') }}></script>
<script src={{ asset('js/selectImg.js') }}></script>
@endsection