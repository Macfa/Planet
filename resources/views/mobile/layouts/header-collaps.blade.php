<div class="collapse" id="header-mypage" style="position:absolute; right:2%; top:6.5%; width:15%">
    <div class="list-group" style="border-radius: 1rem;">
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'post']) }}" class="list-group-item list-group-item-action" aria-current="true">
            내가 쓴 글
        </a>
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'comment']) }}" class="list-group-item list-group-item-action">내가 쓴 댓글</a>
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'scrap']) }}" class="list-group-item list-group-item-action">스크랩</a>
    </div>
</div>
<div class="collapse" id="header-list" style="position:absolute; width:100vw;">
    <div class="list-group">
        <!--name-->
        <a class="fw-bold flex-container disabled list-group-item list-group-item-action"><p>{{ auth()->user()->name }} ( {{ auth()->user()->grade_icon }} )</p></a>
        <!--coin-->
        <a class="fw-bold flex-container disabled list-group-item list-group-item-action"><p>{{ coin_transform() }} Coin</p></a>
        <!--mypage-->
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'post']) }}" class="fw-bold flex-container list-group-item list-group-item-action"><p>마이 페이지</p></a>
        <!--Channels-->
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'channel']) }}" class="fw-bold flex-container list-group-item list-group-item-action">내 토픽</a>

        <div id="collapse_channelJoins">
            @foreach(auth()->user()->allChannels() as $page => $list)
                <a style="padding-left: 30px;" href="{{ route('channel.show', $list->id) }}" class="flex-container list-group-item list-group-item-action"><p>{{ $list->name }}</p></a>
            @endforeach
        </div>
        <a href="{{ route('user.logout') }}" class="fw-bold flex-container list-group-item list-group-item-action"><p>로그아웃</p></a>
    </div>
</div>
<div class="collapse" id="header-noti" style="position:absolute; width:100vw">
    <div class="list-group">
            @forelse(auth()->user()->unreadNotifications as $notification)
{{--                <a href="" class="list-group-item list-group-item-action"><img src="{{ asset('image/scrap_c.png') }}" alt="" class="header-list-icon"><p>{{ $notification->data['msg'] }}</p></a>--}}
                <a href="" class="list-group-item list-group-item-action"><p>{{ $notification->data['msg'] }}</p></a>
            @empty
{{--                <a href="" class="list-group-item list-group-item-action"><img src="{{ asset('image/scrap_c.png') }}" alt="" class="header-list-icon"><p>알림이 없습니다.</p></a>--}}
                <a href="" class="list-group-item list-group-item-action"><p>알림이 없습니다.</p></a>
            @endforelse
    </div>
</div>

<div class="list-group collapse" id="header-search" style="position:fixed; left:10%; top:6.5%; width:30%">
</div>
