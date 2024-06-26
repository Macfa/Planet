@section('mobile.content-mainmenu')
{{--    <ul class="tab_title accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">--}}
{{--        {{ (isset($channel)) ? $channel->name:'실시간 화제글'  }}--}}

    @if(isset($channel))
    <ul id="tab_title_anim" class="tab_title accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">

    @else
        <ul id="tab_title_anim" class="tab_title">
    @endif
        {{ (isset($channel)) ? $channel->name:'실시간 화제글'  }}
    </ul>
    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body-channelinfo">
            @yield('info')
        </div>
    </div>
    <ul class="tab">
        <li class="on clickable realtime" value="realtime" onclick="clickMainMenu('realtime');"><a>실시간</a></li>
        <li class="clickable hot" value="hot" onclick="clickMainMenu('hot');"><a>화제</a></li>
    </ul>
@endsection

@section('mobile.message')
    글이 존재하지 않아요 !
@endsection
