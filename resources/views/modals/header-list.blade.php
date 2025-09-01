<div class="collapse multi-collapse" id="header-list" style="z-index:2000; position:fixed; right:0%; top:6.5%; width:20%">
    <div class="list-group" style="border-radius: 1rem;">
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'post']) }}" class="fw-bold flex-container list-group-item list-group-item-action"><p>마이 페이지</p></a>
        <!--Channels-->
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'channel']) }}" class="fw-bold flex-container list-group-item list-group-item-action">내 토픽</a>

        <div id="collapse_channelJoins">
            {{-- @foreach(auth()->user()->allChannels() as $page => $list)
                <a style="padding-left: 30px;" href="{{ route('channel.show', $list->id) }}" class="flex-container list-group-item list-group-item-action"><p>{{ $list->name }}</p></a>
            @endforeach --}}
        </div>
        <a href="{{ route('logout') }}" class="fw-bold flex-container list-group-item list-group-item-action"><p>로그아웃</p></a>
    </div>
</div>
