@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="form-area">
        <h1 class="form-title">プロフィール設定</h1>
        <form class="form" action="/mypage/profile" method="post">
            @csrf
            <dl>
                <dt class="form-name">ユーザー名</dt>
                <dd class="form-content"><input type="text" name="name" class="form-input" value="{{ old('name') }}" /></dd>
                <dd class="form-error">
                    @error('name'){{ $message }}@enderror
                </dd>
                <dt class="form-name">郵便番号</dt>
                <dd class="form-content"><input type="text" name="post-number" class="form-input"
                        value="{{ old('post-number') }}" /></dd>
                <dd class="form-error">
                    @error('post-number'){{ $message }}@enderror
                </dd>
                <dt class="form-name">住所</dt>
                <dd class="form-content"><input type="text" name="address" class="form-input"
                        value="{{ old('address') }}" />
                </dd>
                <dd class="form-error">
                    @error('address'){{ $message }}@enderror
                </dd>
                <dt class="form-name">ビル名</dt>
                <dd class="form-content"><input type="text" name="building" class="form-input"
                        value="{{ old('building') }}" />
                </dd>
                <dd class="form-error">
                    @error('building'){{ $message }}@enderror
                </dd>
            </dl>
            <button type="submit" class="submit-btn register-btn" name="send">更新する</button>
        </form>
    </div>
@endsection