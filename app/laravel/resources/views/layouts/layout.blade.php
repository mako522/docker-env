<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'パン屋') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/_ajaxlike.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/9c1865d12d.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('stylesheet')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    中村屋
                </a>
                
                <div class="text-right">
                    <a href="{{route('create.time')}}">
                    <button type='button' class='btn btn-primary'>管理者時間追加</button>
                    </a>
                    <a href="{{route('review')}}">
                    <button type='button' class='btn btn-success'>口コミ</button>
                    </a>
                </div>
            </div>
            <div class="my-navbar-control">
                @if(Auth::check())
                <span class="my-navbar-item">{{Auth::user()->name}}</span>
                /
                
                <a href="#" id="logout" class="my-navbar-item">ログアウト</a>
                <form id="logout-form" action="{{route('logout')}}" method="POST" style="display:none;">
                    @csrf
                </form>
                <script>
                    document.getElementById('logout').addEventListener('click',function(event){
                        event.preventDefault();
                        document.getElementById('logout-form').submit();
                    });
                </script>
            @else
                <a class="my-navbar-item" href="{{route('login')}}">ログイン</a>
                /
                <a class="my-navbar-item" href="{{route('register')}}">会員登録</a>
            @endif
            </div>
        </nav>
        @yield('content')
    </div>
</body>
</html> 
<!-- </main> -->


