<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

{{--    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0" />--}}


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

    <link rel="stylesheet" type="text/css" href="{{ asset('css.bak/bootstrap-5.1.0.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css.bak/main/font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css.bak/main/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css.bak/main/layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css.bak/main/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css.bak/toastr.min.css') }}">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap-5.1.0.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/jquery-tmpl.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

<!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>


<body>

<div id="app" class="container-fluid">
    <div id="header" class="row align-items-center">
        <div class="col-md-1"><a href="/"><img src="{{ asset('image/logo.png') }}"></a></div>
        <div class="cst-input-form col-md-4 container">
            <form class="row align-items-center" name="mainSearchForm" id="mainSearchForm" action="{{ route('home.search') }}" method="get">
                {{-- @csrf --}}
                <input type="text" name="searchText" placeholder="검색..." value="{{ Request::input('searchText') }}">
                <input type="hidden" name="searchType" id="searchType" value="a">
                <button type="submit"></button>
            </form>
        </div>
        <div class="cst-icon-list col-md-7 container">
            <div class="row justify-content-end">
                @guest
                    <li class="login"><a href="{{ route('social.oauth', 'google') }}">로그인</a></li>
                @endguest
                @auth
                    <li class="header_icon"><img src="{{ Auth::user()->avatar }}" alt="img" /></li>
                    <li class="header_text header_text_align">
                        <p>{{ Auth::user()->name }}</p>
                    </li>
                    <li class="header_icon"><img src="{{ asset('image/coin_4x.png') }}" alt="coin" /></li>
    {{--                    <li class="header_text ml-0 header_text_align">--}}
                    <li class="header_text header_text_align">
                        <p>
                            {{ coin_transform(\App\Models\Coin::where('coins.userID',auth()->id())
                                ->sum('coin')) }}
                        </p>
                    </li>
                    <li class="header_icon"><a href="/"><img src="{{ asset('image/home_4x.png') }}" alt="home" /></a></li>
                    <li class="header_icon"><a href="{{ route('user.show', auth()->id()) }}"><img src="{{ asset('image/mypage_4x.png') }}" alt="mypage" /></a></li>
                    <li class="header_icon"><img src="{{ asset('image/noti_4x.png') }}" alt="noti" /></li>
                    <li class="header_icon"><img src="{{ asset('image/list_4x.png') }}" alt="list" /></li>
                @endauth
            </div>
        </div>
    </div>
    <div>
        @yield('content')
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()

    toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "300",
        "timeOut": "1500",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    @if(Session::has('msg'))
        var type = "{{ Session::get('type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('msg') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('msg') }}");
                break;
            case 'success':
                toastr.success("{{ Session::get('msg') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('msg') }}");
                break;
        }
    @endif

</script>
</body>
</html>

