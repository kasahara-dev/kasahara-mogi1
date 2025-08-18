@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="tab-titles">
        @if ($tab == 'mylist')
            <a href="/?keyword={{ $keyword }}" class="tab-inactive">おすすめ</a>
            <a href="/?tab=mylist&keyword={{ $keyword }}" class="tab-active">マイリスト</a>
        @else
            <a href="/?keyword={{ $keyword }}" class="tab-active">おすすめ</a>
            <a href="/?tab=mylist&keyword={{ $keyword }}" class="tab-inactive">マイリスト</a>
        @endif
    </div>
    <div class="items-area">
        @if(!is_null($items))
            @foreach ($items as $item)
                <div class="item-area">
                    <a href="/item/{{ $item->id }}" class="item-link">
                        <img title="{{ $item->detail }}" src="{{ asset($item->img_path) }}" alt="{{ $item->name }}"
                            class="item-image" name="{{ $item->id }}" />
                        @if (isset($item->purchase))
                            <div class="item-sold">
                                <p class="item-sold-msg">SOLD</p>
                            </div>
                        @endif
                        <label for="{{ $item->id }}" class="item-name">{{ $item->name }}</label>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
@endsection