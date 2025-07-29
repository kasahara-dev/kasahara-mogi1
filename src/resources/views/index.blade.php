@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="form-area">
        <h1 class="form-title">ログイン</h1>
        <form class="form" action="/confirm" method="post" enctype="multipart/form-data">
            @csrf
            <dl class="form-dl">
                <dt class="form-dt">メールアドレス</dt>
                <dd class="form-dd"><input type="text" class="form-input" /></dd>
                <dt class="form-dt">パスワード</dt>
                <dd class="form-dd"><input type="text" class="form-input" /></dd>
            </dl>
            <button type="submit" class="submit-btn login-btn" name="send">ログインする</button>
        </form>
        <a href="/register" class="link">会員登録はこちら</a>
    </div>
@endsection