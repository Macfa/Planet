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

    <link rel="stylesheet" type="text/css" href="{{ asset('css.bak/bootstrap-5.1.0.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css.bak/main/font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mobile/common/header.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mobile/common/flex.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mobile/main/common.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mobile/main/layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mobile/main/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css.bak/toastr.min.css') }}">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap-5.1.0.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/jquery-tmpl.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script async charset="utf-8" src="//cdn.embedly.com/widgets/platform.js"></script>
    @stack("javascripts")
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

<!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>


<body style="height: calc(var(--vh, 1vh) * 100);">
<!-- Modals -->
<div class="modal fade" id="open_post_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div style="top: 53px; margin: 0px 0px;" class="modal-dialog">
        <div class="modal-content" style="border: 0; border-radius: 0;">
        </div>
    </div>
</div>

<div id="app">
    <div style="width: 100vw; height: calc(var(--vh, 8vh) * 8);" class="row flex-justify-space-between align-self-center" id="header">
        <div class="header-sections col-3">
            <a href="/">
                <img src="{{ asset('image/logo.png') }}">
            </a>
        </div>
        <div class="@if(auth()->check()) col-5 @else col-6 @endif header-sections header-section-search align-self-center">
            <form class="row align-items-center vertical-md" name="mainSearchForm" id="mainSearchForm" action="{{ route('home.search') }}" method="get">
{{--                <input list="searched-list" type="text" name="searchText" onkeydown="searchingCallback(this);" placeholder="검색..." value="{{ Request::input('searchText') }}">--}}
                <input type="text" class="vertical-md" name="searchText" onkeydown="searchingCallback(this);" placeholder="검색..." value="{{ Request::input('searchText') }}">
{{--                <datalist id="searched-list">--}}
{{--                    <option oninput="selectSearchItem();" value="Chocolate">--}}
{{--                    <option value="Coconut">--}}
{{--                    <option value="Mint">--}}
{{--                    <option value="Strawberry">--}}
{{--                    <option value="Vanilla">--}}
{{--                </datalist>--}}
                                <div id="header-search">
{{--                                    <div>--}}
{{--                                        <a href="" class="list-group-item list-group-item-action">Some</a>--}}
{{--                                        <a href="" class="list-group-item list-group-item-action">Some</a>--}}
{{--                                        <a href="" class="list-group-item list-group-item-action">Some</a>--}}
{{--                                    </div>--}}
                                </div>

                <input type="hidden" name="searchType" id="searchType" value="a">
                <button type="submit"></button>

            </form>
        </div>
        <div class="align-self-center header-sections @if(auth()->check()) col-4 @else col-3 @endif">
            @guest
                <ul class="flex-container flex-justify-content-flex-end">
                    <li class="login">
                        <a href="{{ route('social.oauth', 'google') }}">로그인</a>
                    </li>
                </ul>
            @endguest
            @auth
                <ul class="row flex-justify-content-flex-end flex-wrap-nowrap">
{{--                    <li class="header_icon header_icon_clickable"><a class="" data-bs-toggle="collapse" href="#header-mypage" role="button" aria-expanded="false" aria-controls="header-mypage"><img src="{{ asset('image/mypage_4x.png') }}" alt="mypage" /></a></li>--}}

{{--                    <li class="header_icon"><a href="{{ route('user.show', auth()->id()) }}" class="btn btn-primary" data-bs-toggle="collapse" href="#header-mypage" role="button" aria-expanded="false" aria-controls="header-mypage"><img src="{{ asset('image/mypage_4x.png') }}" alt="mypage" /></a></li>--}}

                    <li class="header_icon header_icon_clickable">
                        <a style="position: relative;" class="" data-bs-toggle="collapse" href="#header-noti" role="button" aria-expanded="false" aria-controls="header-noti"><img src="{{ asset('image/noti_4x.png') }}" alt="noti" />
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ auth()->user()->unreadNotifications->count() }}
                                </span><span class="visually-hidden">unread messages</span>
                            @endif
                        </a>
                    </li>
                    <li class="header_icon header_icon_clickable"><a class="" data-bs-toggle="collapse" href="#header-list" role="button" aria-expanded="false" aria-controls="header-list"><img src="{{ asset('image/list_4x.png') }}" alt="list" /></a></li>
                </ul>
            @endauth
        </div>
    </div>
    @auth
    <div class="header-collaps">
        @include('mobile.layouts.header-collaps')
    </div>
    @endauth

    @yield('content')

</div>

<script>
    $('body').on('click', function(e){
        var target = $(e.target);
        // if(target[0].alt !== "noti") {
        var targetNoti = $("#header-noti");
        var targetList = $("#header-list");

        if(targetNoti.hasClass("show")) {
            targetNoti.toggleClass("show");
        }
        // } else if(target[0].alt !== "list") {

        if(targetList.hasClass("show")) {
            targetList.toggleClass("show");
        }
        // }
        // var $popCallBtn = $tgPoint.hasClass('JS-popup-btn')
        // var $popArea = $tgPoint.hasClass('popup-box')
        //
        // if ( !$popCallBtn && !$popArea ) {
        //     $('.popup-box').removeClass('view');
        // }
    });
    var timer = null;
    $(document).ready(function () {
        let vh = window.innerHeight * 0.01;

        document.documentElement.style.setProperty('--vh', `${vh}px`);
        window.addEventListener('resize', () => {
            let vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        });

        $('#open_post_modal').on('shown.bs.modal', function() {
            $(document).off('focusin.modal');
        });
        var myCollapsible = document.getElementById('header-noti');
        if(myCollapsible) {
            myCollapsible.addEventListener('show.bs.collapse', function () {
                $.ajax({
                    type: "get",
                    url: "/mark",
                })
            });
        }
    });

    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    // function setScreenSize() {
    //     let vh = window.innerHeight * 0.01;
    //
    //     document.documentElement.style.setProperty('--vh', `${vh}px`);
    // }
    // setScreenSize();
    // window.addEventListener('resize', () => setScreenSize());


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

                if(data['list'] === null) {
                    // pass
                    // dataToAppend.push('<a href="" class="list-group-item list-group-item-action">검색</a>');
                } else {
                    $.each(data['list'], function(idx,val) {
                        if(data['type'] == "channel") {
                            dataToAppend.push('<a href="/channel/'+val['id']+'" class="list-group-item list-group-item-action">'+val['name']+'</a>');
                        } else if(data['type'] == "post") {
                            dataToAppend.push('<a href="/post/'+val['id']+'" class="list-group-item list-group-item-action">'+val['title']+'</a>');
                            // dataToAppend.push('<a href="/post/'+val['id']+'" class="list-group-item list-group-item-action">'+val['title']+'</a>');
                        }
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
    function notLogged() {
        // if(!auth()->check()) {
        alert("로그인이 필요한 기능입니다");
        return;
        // }
    }

</script>
</body>
</html>

