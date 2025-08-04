@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
    <div class="form-area">
        <h1 class="form-title">会員登録</h1>
        <form class="form" action="/register" method="post">
            @csrf
            <dl>
                <dt class="form-name">ユーザー名</dt>
                <dd class="form-content"><input type="text" name="name" class="form-input" value="{{ old('name') }}" /></dd>
                <dd class="form-error">@error('name'){{ $message }}@enderror</dd>
                <dt class="form-name">メールアドレス</dt>
                <dd class="form-content"><input type="email" name="email" class="form-input" value="{{ old('email') }}" />
                </dd>
                <dd class="form-error">@error('email'){{ $message }}@enderror</dd>
                <dt class="form-name">パスワード</dt>
                <dd class="form-content"><input type="password" name="password" class="form-input"
                        value="{{ old('password') }}" /></dd>
                <dd class="form-error">
                    @error('password')
                        @foreach ($errors->get('password') as $message)
                            @if(Str::contains($message, config('word.match')))
                            @else
                                {{ $message }}
                                @break
                            @endif
                        @endforeach
                    @enderror
                </dd>
                <dt class="form-name">確認用パスワード</dt>
                <dd class="form-content"><input type="password" name="password_confirmation" class="form-input"
                        value="{{ old('password_confirmation') }}" /></dd>
                <dd class="form-error">
                    @error('password')
                        @foreach ($errors->get('password') as $message)
                            @if(Str::contains($message, config('word.match')))
                                {{ $message }}
                            @endif
                        @endforeach
                    @enderror
                </dd>
            </dl>
            <button type="submit" class="submit-btn register-btn" name="send">登録する</button>
        </form>
        <a href="/login" class="link">ログインはこちら</a>
    </div>
@endsection