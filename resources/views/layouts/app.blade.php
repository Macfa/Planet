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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main/index.css') }}">
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
<!-- Modal -->
<div style="top: 57px; height: 95%;" class="modal fade" id="open_post_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        </div>
    </div>
</div>

{{-- This Section must be delete. it's code for test noti--}}
{{--    <a href="{{ route('test.noti') }}">--}}
{{--<div style="height:58px;">--}}
{{--    test for noti--}}
{{--</div>--}}
{{--    </a>--}}

{{--<a href="{{ route('test.noti2') }}">--}}
{{--    <div style="height:58px;">--}}
{{--        get noti--}}
{{--        @if(Session::has('data'))--}}
{{--            <div>{{ Session::get('data') }}</div>--}}
{{--            @endif--}}
{{--    </div>--}}
{{--</a>--}}

<div id="app" class="container-fluid">
    <div class="row align-items-center" id="header">
        <div class="col-md-1"><a href="/"><img src="{{ asset('image/logo.png') }}"></a></div>
        <div class="cst-input-form col-md-4 container">
            <form class="row align-items-center" name="mainSearchForm" id="mainSearchForm" action="{{ route('home.search') }}" method="get">
                {{-- @csrf --}}
                <input type="text" name="searchText" onkeydown="searchingCallback(this);" placeholder="검색..." value="{{ Request::input('searchText') }}">
{{--                <div id="searchRecomment">--}}
{{--                    <div>--}}
{{--                        <a href="" class="list-group-item list-group-item-action">Some</a>--}}
{{--                        <a href="" class="list-group-item list-group-item-action">Some</a>--}}
{{--                        <a href="" class="list-group-item list-group-item-action">Some</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
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
                    <li class="header_icon header_icon_clickable"><a href="/"><img src="{{ asset('image/home_4x.png') }}" alt="home" /></a></li>
                    <li class="header_icon header_icon_clickable"><a class="" data-bs-toggle="collapse" href="#header-mypage" role="button" aria-expanded="false" aria-controls="header-mypage"><img src="{{ asset('image/mypage_4x.png') }}" alt="mypage" /></a></li>

{{--                    <li class="header_icon"><a href="{{ route('user.show', auth()->id()) }}" class="btn btn-primary" data-bs-toggle="collapse" href="#header-mypage" role="button" aria-expanded="false" aria-controls="header-mypage"><img src="{{ asset('image/mypage_4x.png') }}" alt="mypage" /></a></li>--}}

                    <li class="header_icon header_icon_clickable"><a class="" data-bs-toggle="collapse" href="#header-noti" role="button" aria-expanded="false" aria-controls="header-noti"><img src="{{ asset('image/noti_4x.png') }}" alt="noti" /></li></a>
                    <li class="header_icon header_icon_clickable"><a class="" data-bs-toggle="collapse" href="#header-list" role="button" aria-expanded="false" aria-controls="header-list"><img src="{{ asset('image/list_4x.png') }}" alt="list" /></a></li>
                @endauth
            </div>
        </div>
    </div>
    @auth
    <div class="header-collaps">
        @include('layouts.header-collaps')
    </div>
    @endauth
    <div>

        @yield('content')
    </div>
</div>

<script>
    var timer = null;
    function searchingCallback() {
        // var timer = null;

        if (timer) {
            window.clearTimeout(timer);
        }
        timer = window.setTimeout( function() {
            timer = null;
            search();
        }, 600 );
    }

    function search() {
        var obj = $("input[name=searchText]");
        var word = obj.val();
        // var word = encodeURI(word);
        // return;
        $.ajax({
            type: "get",
            url: "/searchHelper",
            data: {
                'searchText': word
            },
            success: function(data) {
                var elementToPlace = $("#header-search");
                var dataToAppend = [];

                elementToPlace.children().remove();
                console.log(data);
                if(data === null) {
                    // pass
                    // dataToAppend.push('<a href="" class="list-group-item list-group-item-action">검색</a>');
                } else {
                    $.each(data, function(idx,val) {
                        dataToAppend.push('<a href="/channel/'+val['id']+'" class="list-group-item list-group-item-action">'+val['name']+'</a>');
                    });
                }
                elementToPlace.append(dataToAppend);

                {{--if(data.result=='created') {--}}
                {{--    var url = '{{ route('channel.show', ":id") }}';--}}
                {{--    url = url.replace(':id', data.channelID);--}}
                {{--    $('.category').append('<li class="channel_'+data.channel.id+'"><a href="'+url+'">'+data.channel.name+'</a></li>');--}}
                {{--    $('.totalCount').text(data.totalCount);--}}
                {{--} else if(data.result=='deleted') {--}}
                {{--    $('.category li.channel_'+data.id).remove();--}}
                {{--    $('.totalCount').text(data.totalCount);--}}
                {{--}--}}
            },
            error: function(err) {
                // console.log(err);
            }
        })
    }

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

