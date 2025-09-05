@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="form-area">
        <h1 class="form-title">プロフィール設定</h1>
        <form class="form" action="/mypage/profile" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="img-area">
                <img id="user-img" class="user-img" src="{{ asset(auth()->user()->profile->img_path) }}" alt="ユーザーアイコン" />
                <input id="fileElem" name="userImgInput" type="file" class="profile-img-input" />
                <button id="fileSelect" type="button" name="profile-img-btn" class="profile-img-btn">画像を選択する</button>
            </div>
            <div class="form-error">
                @error('userImgInput')
                    {{ $message }}
                @enderror
            </div>
            <dl>
                <dt class="form-name">ユーザー名</dt>
                <dd class="form-content"><input type="text" name="name" class="form-input"
                        value="{{ old('name', auth()->user()->name) }}" /></dd>
                <dd class="form-error">
                    @error('name'){{ $message }}@enderror
                </dd>
                <dt class="form-name">郵便番号</dt>
                <dd class="form-content"><input type="text" name="postNumber" class="form-input"
                        value="{{ old('postNumber', auth()->user()->profile->address->post_number) }}" /></dd>
                <dd class="form-error">
                    @error('postNumber'){{ $message }}@enderror
                </dd>
                <dt class="form-name">住所</dt>
                <dd class="form-content"><input type="text" name="address" class="form-input"
                        value="{{ old('address', auth()->user()->profile->address->address) }}" />
                </dd>
                <dd class="form-error">
                    @error('address'){{ $message }}@enderror
                </dd>
                <dt class="form-name">ビル名</dt>
                <dd class="form-content"><input type="text" name="building" class="form-input"
                        value="{{ old('building', auth()->user()->profile->address->building) }}" />
                </dd>
                <dd class="form-error">
                    @error('building'){{ $message }}@enderror
                </dd>
            </dl>
            <button type="submit" class="submit-btn register-btn" name="send">更新する</button>
        </form>
    </div>
    <script src="{{ asset('/js/profileImg.js') }}"></script>
@endsection