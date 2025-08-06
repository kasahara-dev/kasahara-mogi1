@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="form-area">
        <h1 class="form-title">ログイン</h1>
        <form class="form" action="/login" method="post" novalidate>
            @csrf
            <dl>
                <dt class="form-name">メールアドレス</dt>
                <dd class="form-content"><input type="text" class="form-input" name="email" value="{{ old('email') }}" />
                </dd>
                <dd class="form-error">@error('email'){{ $message }}@enderror</dd>
                <dt class="form-name">パスワード</dt>
                <dd class="form-content"><input type="password" class="form-input" name="password"
                        value="{{ old('password') }}" /></dd>
                <dd class="form-error">@error('password'){{ $message }}@enderror</dd>
            </dl>
            <button type="submit" class="submit-btn login-btn" name="send">ログインする</button>
        </form>
        <a href="/register" class="link">会員登録はこちら</a>
    </div>
@endsection