@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <div class="contents-area">
        <div class="edit-area">
            <div class="item-area">
                <img class="item-img" src="{{ asset($item->img_path) }}" alt="商品画像">
                <div class="item-info">
                    <div class="item-name">{{ $item->name }}</div>
                    <div class="item-price">&yen;<span class="price">{{ number_format($item->price) }}</span></div>
                </div>
            </div>
            <form action="/purchase/{{ $item->id }}" method="POST">
                @csrf
                <dl class="purchase-list">
                    <dt class="purchase-list-title">支払い方法</dt>
                    <dd class="purchase-list-detail">
                        <select class="payment-select" name="payment" id="payment-select" onchange="paymentValue()">
                            <option value="" selected hidden>選択してください</option>
                            @foreach(config('payment') as $paymentId => $paymentName)
                                <option value="{{ $paymentId }}">{{ $paymentName }}</option>
                            @endforeach
                        </select>
                    </dd>
                    <dd class="form-error">@error('payment'){{ $message }}@enderror</dd>
                </dl>
                <dl class="purchase-list">
                    <dt class="purchase-list-title">配送先
                        @if (isset($address))
                            <a class="purchase-address-link"
                                href="/purchase/address/{{ $item->id }}?addressId={{ $address->id }}">変更する</a>
                        @else
                            <a class="purchase-address-link" href="/purchase/address/{{ $item->id }}">変更する</a>
                        @endif
                    </dt>
                    <dd class="purchase-list-detail">
                        @if (isset($address))
                            <div class="address-line">〒{{ $address->post_number }}</div>
                            <div class="address-line">{{ $address->address }}</div>
                            <div class="address-line">{{ $address->building }}</div>
                        @endif
                    </dd>
                    <dd class="form-error">@error('address'){{ $message }}@enderror</dd>
                </dl>
        </div>
        <div class="confirm-area">
            <dl class="confirm-list">
                <div class="confirm-line">
                    <dt class="confirm-title">商品代金</dt>
                    <dd class="confirm-detail">&yen;{{ number_format($item->price) }}</dd>
                </div>
                <div class="confirm-line confirm-line-last">
                    <dt class="confirm-title">支払い方法</dt>
                    <dd class="confirm-detail"><span id="payment-name"></span></dd>
                </div>
            </dl>
            @if (isset($address))
                <input type="hidden" name="address" value="{{ $address->id }}" />
            @else
                <input type="hidden" name="address" value="" />
            @endif
            <button type="submit" class="wide-btn">購入する</button>
            </form>
        </div>
    </div>
    <script>
        const paymentList = @json(config('payment'));
    </script>
    <script src="{{ asset('/js/payment.js') }}"></script>
@endsection