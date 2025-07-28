@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="form__area">
        <h1 class="form__title">Contact</h1>
        <form class="form" action="/confirm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="button__area">
                <button type="submit" class="submit__button" name="send">確認画面</button>
            </div>
        </form>
    </div>
@endsection