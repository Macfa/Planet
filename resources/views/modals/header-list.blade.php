{{--<div class="collapse" id="header-list" style="z-index:2000; position:absolute; right:2%; top:6.5%; width:15%">--}}
{{--    <div class="list-group" style="border-radius: 1rem;">--}}
{{--        <a href="" class="list-group-item list-group-item-action">Some</a>--}}
{{--        <a href="" class="list-group-item list-group-item-action">Some</a>--}}
{{--        <a href="{{ route('user.logout') }}" class="list-group-item list-group-item-action">로그아웃</a>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<div class="collapse" id="header-list" style="z-index:1055; position:absolute; width:100vw;">--}}
<div class="collapse multi-collapse" id="header-list" style="z-index:2000; position:fixed; right:0%; top:6.5%; width:20%">
    <div class="list-group" style="border-radius: 1rem;">
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'post']) }}" class="fw-bold flex-container list-group-item list-group-item-action"><p>마이 페이지</p></a>
        <!--Channels-->

        <a href="" class="fw-bold flex-container list-group-item list-group-item-action">내 동아리</a>

        <div id="collapse_channelJoins">
            @foreach(auth()->user()->allChannels() as $joined)
{{--                <a style="padding-left: 30px;" href="{{ route('channel.show', $joined->channel->id) }}" class="flex-container list-group-item list-group-item-action"><img src="{{ asset('image/scrap_c.png') }}" alt="" class="header-list-icon"><p>{{ $joined->channel->name }}</p></a>--}}
                <a style="padding-left: 30px;" href="{{ route('channel.show', $joined->id) }}" class="flex-container list-group-item list-group-item-action"><p>{{ $joined->name }}</p></a>
                @if($loop->index === 9)
                    <a>더보기</a>
                @endif
            @endforeach
        </div>
        <a href="{{ route('user.logout') }}" class="fw-bold flex-container list-group-item list-group-item-action"><p>로그아웃</p></a>
    </div>
</div>
