<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0" />

    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>


    <meta property="og:type" content="website">
    <meta property="og:title" content="밈클라우드,memecloud">
    <meta property="og:description" content="사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.">
    <meta property="og:image" content="/image/tab_image.png">
    <meta property="og:url" content="">

    <meta name="description" content="어쩌면 마음이 맞는 친구를 찾을지도 모릅니다." />
    <meta name="keywords" content="community" />
    <meta name="author" content="macfa" />


    <title>밈클라우드</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-5.1.0.min.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common/flex.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}"> --}}

    {{-- <script src="{{ asset('js/jquery.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/jquery-tmpl.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/jquery-ui.min.js') }}"></script> --}}
    <script charset="utf-8" src="//cdn.iframe.ly/embed.js?api_key=ddc93c9ff7add82b1b3370"></script>

    @stack("styles")
</head>
