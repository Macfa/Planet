<div class="row flex-justify-space-between align-self-center" id="header">
    <div class="col-3">
        <a href="/">
            <img src="{{ asset('image/logo_v1.png') }}">
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
{{--            <div id="header-search">--}}
                {{--                                    <div>--}}
                {{--                                        <a href="" class="list-group-item list-group-item-action">Some</a>--}}
                {{--                                        <a href="" class="list-group-item list-group-item-action">Some</a>--}}
                {{--                                        <a href="" class="list-group-item list-group-item-action">Some</a>--}}
                {{--                                    </div>--}}
{{--            </div>--}}

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

{{--@yield('content')--}}
