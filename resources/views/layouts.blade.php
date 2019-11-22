<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Web Shop</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div class="navbar navbar-expand-sm bg-dark navbar-dark">
            <a href="#" class="navbar-brand">Web Shop</a>
            <ul class="navbar-nav">
                <li class="nav-item"><a href="/shop" class="nav-link">home</a></li>
                <li class="nav-item"><a href="/home" class="nav-link">account
                        @if(Auth::user())
                        <span class="badge badge-info unread"> {{count(Auth::user()->unreadNotifications)}}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item"><a href="/cart" class="nav-link">cart</a></li>
            </ul>
            @if(Auth::check())
            <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="/admin" class="nav-link text-warning">Admin Test</a></li>
                <li class="nav-item"><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="nav-link">登出</a></li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @else
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="/login" class="nav-link">登入</a></li>
                <li class="nav-item"><a href="/register" class="nav-link">註冊</a></li>
                <li class="nav-item"><a href="/admin" class="nav-link">Admin Test</a></li>
            </ul>
            @endif
        </div>
        <div class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" style="height:300px;width:100%;">
                <div class="carousel-item active">
                    <img src="img/banner1.png" style="height:300px;width:100%;" alt="">
                </div>
                <div class="carousel-item ">
                    <img src="img/banner2.png" style="height:300px;width:100%;"alt="">
                </div>
                <div class="carousel-item ">
                    <img src="img/banner3.png" style="height:300px;width:100%;"alt="">
                </div>
            </div>
        </div>
        @yield('content')
    </div>
</body>

</html>