<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <div class="wrapper">
        <header class="header">
            @section('header')
            <img src="{{ asset('img/logo.svg') }}" alt="コーチテックロゴ" class="header-img" />
            @show
        </header>
        <main class="main">
            @yield('content')
        </main>
    </div>
</body>

</html>