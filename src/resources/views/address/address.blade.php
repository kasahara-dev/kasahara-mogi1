@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
    <div class="form-area">
        <h1 class="form-title">住所の変更</h1>
        <form class="form" action="/purchase/address/{{ $item_id }}" method="post">
            @csrf
            <dl>
                <dt class="form-name">郵便番号</dt>
                <dd class="form-content">
                    {{-- @if(isset($address)) --}}
                    <input type="text" class="form-input" name="post_number"
                        value="{{ old('post_number', $post_number) }}" />
                </dd>
                <dd class="form-error">@error('postNumber'){{ $message }}@enderror</dd>
                <dt class="form-name">住所</dt>
                <dd class="form-content">
                    {{-- @if(isset($address)) --}}
                    <input type="text" class="form-input" name="address" value="{{ old('address', $address) }}" />
                </dd>
                <dd class="form-error">@error('address'){{ $message }}@enderror</dd>
                <dt class="form-name">建物名</dt>
                <dd class="form-content">
                    <input type="text" class="form-input" name="building" value="{{ old('building', $building) }}" />
                </dd>
                <dd class="form-error"></dd>
            </dl>
            <input type="hidden" name="payment" value="{{ $payment }}" />
            <button type="submit" class="wide-btn">更新する</button>
        </form>
    </div>
@endsection