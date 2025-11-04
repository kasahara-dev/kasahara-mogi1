@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    <div class="form-area">
        <h1 class="form-title">商品の出品</h1>
        <form class="form" action="/sell" method="post" enctype="multipart/form-data">
            @csrf
            <dl>
                <dt class="form-name">商品画像</dt>
                <dd class="form-content">
                    <div class="img-area">
                        <img id="user-img" class="user-img" />
                        <input id="fileElem" name="item_img_input" type="file" class="item-img-input" />
                        <button id="fileSelect" type="button" name="item-img-btn" class="item-img-btn">画像を選択する</button>
                    </div>
                    <div class="form-error">
                        @error('item_img_input')
                            {{ $message }}
                        @enderror
                    </div>
                </dd>
                <section>
                    <h2 class="section-title">商品の詳細</h2>
                    <dt class="form-name">カテゴリー</dt>
                    <dd class="form-content">
                        <div class="categories-area">
                            @foreach ($categories as $category)
                                <input type="checkbox" value="{{ $category->id }}" name="category[]" id="category_{{$category}}"
                                    class="category-input" @if(!empty(old('category')) && in_array(($category->id), old('category'))) checked @endif />
                                <label for="category_{{ $category }}" class="category-label">{{ $category->name }}</label>
                            @endforeach
                        </div>
                        <div class="form-error">
                            @error('category')
                                {{ $message }}
                            @enderror
                        </div>
                    </dd>
                    <dt class="form-name"><label for="condition">商品の状態</label></dt>
                    <dd class="form-content">
                        <select name="condition" id="condition" class="condition-area">
                            <option value="" selected hidden>選択してください</option>
                            @foreach (config('condition') as $conditionId => $conditionName)
                                <option value="{{ $conditionId }}" @if(!empty(old('condition')) && old('condition') == $conditionId) selected @endif)>{{ $conditionName }}</option>
                            @endforeach
                        </select>
                        <div class="form-error">
                            @error('condition')
                                {{ $message }}
                            @enderror
                        </div>
                    </dd>
                </section>
                <section>
                    <h2 class="section-title">商品名と説明</h2>
                    <dt class="form-name"><label for="itemName">商品名</label></dt>
                    <dd class="form-content">
                        <input type="text" class="item-name" id="itemName" name="itemName" value="{{ old('itemName') }}" />
                        <div class="form-error">
                            @error('itemName')
                                {{ $message }}
                            @enderror
                        </div>
                    </dd>
                    <dt class="form-name"><label for="brandName">ブランド名</label></dt>
                    <dd class="form-content">
                        <input type="text" class="brand-name" id="brandName" name="brandName"
                            value="{{ old('brandName') }}" />
                    </dd>
                    <dt class="form-name"><label for="itemInfo">商品の説明</label></dt>
                    <dd class="form-content">
                        <textarea class="item-info" id="itemInfo" name="itemInfo">{{ old('itemInfo') }}</textarea>
                        <div class="form-error">
                            @error('itemInfo')
                                {{ $message }}
                            @enderror
                        </div>
                    </dd>
                    <dt class="form-name"><label for="price">販売価格</label></dt>
                    <dd class="form-content price-content">
                        <div class="price-area">
                            <input type="number" class="price" id="price" name="price" value="{{ old('price') }}" />
                        </div>
                    </dd>
                    <div class="form-error">
                        @error('price')
                            {{ $message }}
                        @enderror
                    </div>
                </section>
            </dl>
            <button type="submit" class="submit-btn exhibition-btn" name="send">出品する</button>
        </form>
    </div>
    <script src="{{ asset('/js/selectImg.js') }}"></script>
@endsection