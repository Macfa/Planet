<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0" />

    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
{{--    <meta http-equiv="Cache-Control" content="no-cache"/>--}}
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>


    <meta property="og:type" content="website">
    <meta property="og:title" content="밈클라우드,memecloud">
    <meta property="og:description" content="사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.">
    <meta property="og:image" content="/image/tab_image.png">
    <meta property="og:url" content="">

    <meta name="description" content="어쩌면 마음이 맞는 친구를 찾을지도 모릅니다." />
    <meta name="keywords" content="" />
{{--    <meta name="Referrer-Policy" content="no-referrer" />--}}
    <meta name="author" content="" />
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}


    <title>밈클라우드</title>
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('image/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('image/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('image/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('image/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('image/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('image/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('image/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('image/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('image/tab_image.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/tab_image.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/tab_image.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('image/tab_image.png') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-5.1.0.min.css') }}">
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common/flex.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap-5.1.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery-tmpl.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key=ddc93c9ff7add82b1b3370"></script>

    @stack("styles")
</head>

<body>

<!-- Modals -->
<div class="modal fade" id="open_post_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="height: auto; width: 80%; max-width: none; top: 53px; margin-top: 0px;" class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>

<div id="app" class="wid100">
    @include('partials.header')

    <div>
        @yield('main')
    </div>
</div>

@auth
    @include('modals.header-noti')
    @include('modals.header-list')
@endauth
@stack("modals")

@if(Session::has('msg'))
    <script>alert("{{ Session::get('msg') }}");</script>
@endif

<script src="{{ asset('js/common.js') }}"></script>
<script>

    $(document).ready(function () {
        let vh = window.innerHeight * 0.01;

        document.documentElement.style.setProperty('--vh', `${vh}px`);
        window.addEventListener('resize', () => {
            let vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        });
    });
</script>
@stack("scripts")

</body>
</html>

