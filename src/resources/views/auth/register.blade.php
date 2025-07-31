@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
    <div class="form-area">
        <h1 class="form-title">会員登録</h1>
        <form class="form" action="/register" method="post">
            @csrf
            <dl class="form-dl">
                <dt class="form-dt">ユーザー名</dt>
                <dd class="form-dd"><input type="text" class="form-input" /></dd>
                <dt class="form-dt">メールアドレス</dt>
                <dd class="form-dd"><input type="text" class="form-input" /></dd>
                <dt class="form-dt">パスワード</dt>
                <dd class="form-dd"><input type="text" class="form-input" /></dd>
                <dt class="form-dt">確認用パスワード</dt>
                <dd class="form-dd"><input type="text" class="form-input" /></dd>
            </dl>
            <button type="submit" class="submit-btn register-btn" name="send">登録する</button>
        </form>
        <a href="/login" class="link">ログインはこちら</a>
    </div>
@endsection