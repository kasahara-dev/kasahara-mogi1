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
                    @if(isset($address))
                        <input type="text" class="form-input" name="postNumber"
                            value="{{ old('postNumber', $address->post_number) }}" />
                    @else
                        <input type="text" class="form-input" name="postNumber" value="{{ old('postNumber') }}" />
                    @endif
                </dd>
                <dd class="form-error">@error('post-number'){{ $message }}@enderror</dd>
                <dt class="form-name">住所</dt>
                <dd class="form-content">
                    @if(isset($address))
                        <input type="text" class="form-input" name="address" value="{{ old('address', $address->address) }}" />
                    @else
                        <input type="text" class="form-input" name="address" value="{{ old('address') }}" />
                    @endif
                </dd>
                <dd class="form-error">@error('address'){{ $message }}@enderror</dd>
                <dt class="form-name">建物名</dt>
                <dd class="form-content">
                    @if(isset($address))
                        <input type="text" class="form-input" name="building"
                            value="{{ old('building', $address->building) }}" />
                    @else
                        <input type="text" class="form-input" name="building" value="{{ old('building') }}" />
                    @endif
                </dd>
                <dd class="form-error"></dd>
            </dl>
            <button type="submit" class="wide-btn">更新する</button>
        </form>
    </div>
@endsection