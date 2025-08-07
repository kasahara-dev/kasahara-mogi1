<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <div class="wrapper">
        <header class="header">
            @section('header')
            <a href="/" class="header-logo"><img src="{{ asset('img/logo.svg') }}" alt="コーチテックロゴ"
                    class="header-img" /></a>
            @show
            @auth
                <form action="/" method="get" class="header-form">
                    @csrf
                    <input type="search" placeholder="なにをお探しですか?" class="header-search">
                </form>
                <ul class="header-btns">
                    <li class="header-btn">
                        <form class="header-form" action="/logout" method="post" class="header-btn">
                            @csrf
                            <button type="submit" class="header-logout" name="logout">ログアウト</button>
                        </form>
                    </li>
                    <li class="header-btn"><a href="/mypage" class="header-mypage">マイページ</a></li>
                    <li class="header-btn"><button onclick="location.href='/sell'" class="header-exhibit">出品</button></li>
                </ul>
            @endauth
        </header>
        <main class="main">
            @yield('content')
        </main>
    </div>
</body>

</html>