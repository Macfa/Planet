<div class="d-flex align-items-center" id="header">
    <div style="flex: 1 0 auto;" class="header-sections">
        <a href="/">
            <img src="{{ asset('image/logo.png') }}">
        </a>
    </div>
    <div style="flex: 5 5 auto;" class="header-sections header-section-search">
        <form class="row align-items-center" name="mainSearchForm" id="mainSearchForm" action="{{ route('home.search') }}" method="get">
                <input list="searched-list" type="text" name="searchText" onkeydown="searchingCallback(this);" placeholder="검색..." value="{{ Request::input('searchText') }}">
{{--            <input type="text" name="searchText" onkeydown="searchingCallback(this);" placeholder="검색..." value="{{ Request::input('searchText') }}">--}}
                <datalist id="searched-list">
{{--                    <optgroup label="추천 검색어">--}}
{{--                    </optgroup>--}}
                </datalist>
                <input type="hidden" name="searchType" id="searchType" value="a">
                <button type="submit"></button>
        </form>
    </div>
    <div style="flex: 6 6 auto;" class="header-sections">
        @guest
            <ul class="d-flex flex-justify-content-flex-end">
                <li class="login">
                    <a href="{{ route('social.oauth', 'google') }}">로그인</a>
                </li>
            </ul>
        @endguest
        @auth
            <ul class="d-flex flex-justify-content-flex-end flex-wrap-nowrap">
                <li class="mr-2 header_icon"><a href="{{ route('user.show', auth()->id()) }}"><img src="{{ auth()->user()->avatar }}" alt="img" /></a></li>
                <li class="mr-3 header_text header_text_align">
                    <p>{{ Auth::user()->name }}</p>
                </li>
                <li class="mr-2 header_icon"><img src="{{ asset('image/coin_4x.png') }}" alt="coin" /></li>
                {{--                    <li class="header_text ml-0 header_text_align">--}}
                <li class="mr-3 header_text header_text_align">
                    <p id="total_coin">
                        {{ coin_transform() }}
                    </p>
                </li>
{{--                <li class="mr-2 header_icon header_icon_clickable"><a href="/"><img src="{{ asset('image/home_4x.png') }}" alt="home" /></a></li>--}}
{{--                <li class="mr-2 header_icon header_icon_clickable"><a class="" data-bs-toggle="collapse" href="#header-mypage" role="button" aria-expanded="false" aria-controls="header-mypage"><img src="{{ asset('image/mypage_4x.png') }}" alt="mypage" /></a></li>--}}

                {{--                    <li class="header_icon"><a href="{{ route('user.show', auth()->id()) }}" class="btn btn-primary" data-bs-toggle="collapse" href="#header-mypage" role="button" aria-expanded="false" aria-controls="header-mypage"><img src="{{ asset('image/mypage_4x.png') }}" alt="mypage" /></a></li>--}}
                <li class="mr-2 header_icon header_icon_clickable">
                    <a style="position: relative;" class="" data-bs-toggle="collapse" data-bs-target="#header-noti" role="button" aria-expanded="false" aria-controls="header-noti"><img src="{{ asset('image/noti_4x.png') }}" alt="noti" />
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span><span class="visually-hidden">unread messages</span>
                        @endisset
                    </a>
                </li>
                <li class="header_icon header_icon_clickable"><a class="" data-bs-toggle="collapse" data-bs-target="#header-list" role="button" aria-expanded="false" aria-controls="header-list"><img src="{{ asset('image/list_4x.png') }}" alt="list" /></a></li>
            </ul>
        @endauth
    </div>
</div>
