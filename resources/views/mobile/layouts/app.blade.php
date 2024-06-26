<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="height=device-height, width=device-width, user-scalable=yes, initial-scale=1.0" />

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

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('image/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('image/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('image/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('image/favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('image/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('image/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('image/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('image/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('image/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('image/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('image/favicon/favicon-96x96.png') }}">

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
    {{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>--}}
    {{--    <script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>--}}

    {{--    <script src="https://unpkg.com/@popperjs/core@2"></script>--}}
    {{--    <script src="{{ asset('js/toastr.min.js') }}"></script>--}}
    <script src="{{ asset('js/jquery-tmpl.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    {{--    <script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>--}}
    <script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key=ddc93c9ff7add82b1b3370"></script>

    @stack("styles")
</head>


<body style="height: calc(var(--vh, 1vh) * 100);">

{{--@if(session('status'))--}}
{{--    <script>--}}
{{--    var status = "{{ session('status') }}";--}}
{{--    switch(status){--}}
{{--        case 'info':--}}
{{--        toastr.info("{{ session('message') }}");--}}
{{--        break;--}}
{{--        case 'warning':--}}
{{--        toastr.warning("{{ session('message') }}");--}}
{{--        break;--}}
{{--        case 'success':--}}
{{--        toastr.success("{{ session('message') }}");--}}
{{--        break;--}}
{{--        case 'error':--}}
{{--        toastr.error("{{ session('message') }}");--}}
{{--        break;--}}
{{--    }--}}
{{--    </script>--}}
{{--@endif--}}

<!-- Modals -->
<div class="modal fade" id="open_post_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="margin: 0px 0px;" class="modal-dialog">
        <div class="modal-content" style="border: 0; border-radius: 0;">
        </div>
    </div>
</div>

<div id="app">

</div>

@auth
    @include('modals.header-noti')
    {{--    @include('modals.header-mypage')--}}
    @include('modals.header-list')
@endauth
@stack("modals")

@if(Session::has('msg'))
    <script>alert("{{ Session::get('msg') }}");</script>
@endif

<script src="{{ asset('js/common.js') }}"></script>
@stack("scripts")

</body>
</html>

