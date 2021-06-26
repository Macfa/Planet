<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
      <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0" />

    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>


    <meta property="og:type" content="website">
    <meta property="og:title" content="몽드">
    <meta property="og:description" content="사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.">
    <meta property="og:image" content="../img/favicon/og_img.png">
    <meta property="og:url" content="">

    <meta name="description" content="어쩌면 마음이 맞는 친구를 찾을지도 모릅니다." />
    <meta name="keywords" content="" />
    <meta name="author" content="" />

    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}


    <title>Monde</title>
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}

    <link rel="apple-touch-icon" sizes="57x57" href="../img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/favicon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/favicon/favicon-96x96.png">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/index.css') }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-tmpl.js') }}"></script>
    <script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>


<body>
  <div id="app">
  <div>
  <header id="header">
    <h1><a href="/"><img src="../img/logo.png"></a></h1>
    <div class="input">
      <form name="mainSearchForm" action="{{ route('mainSearch') }}" autocomplete="" enctype="" method="get" target="">
        {{-- @csrf --}}
        <input type="text" name="searchText" placeholder="검색..." value="{{ Request::input('searchText') }}">
        <input type="hidden" name="searchType">
        <button type="submit"></button>
      </form>
    </div>
    <ul class="btn">
        @guest
            <li class="login"><a href="{{ route('social.oauth', 'google') }}">로그인</a></li>
        @else
            <li class="login"><img src="{{ asset('image/arrow-bot.png') }}" alt="뒤로" /></li>
            <li class="login"><img src="{{ asset('image/arrow-bot.png') }}" alt="뒤로" /></li>
            <li class="login"><img src="{{ asset('image/arrow-bot.png') }}" alt="뒤로" /></li>
            <li class="login"><img src="{{ asset('image/arrow-bot.png') }}" alt="뒤로" /></li>
            {{ Auth::user()->name }}
        @endguest
      </div>
    </ul>
  </header>
  <div>
  @yield('content')
  </div>
</div>
</div>

<!-- Scripts -->
{{-- <script src="{{ asset('js/jquery.js') }}"></script> --}}
<script>
  $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
</script>
</body>
</html>

