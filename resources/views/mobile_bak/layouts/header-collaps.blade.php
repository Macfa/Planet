<div class="collapse" id="header-mypage" style="z-index:1055; position:absolute; right:2%; top:6.5%; width:15%">
    <div class="list-group" style="border-radius: 1rem;">
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'post']) }}" class="list-group-item list-group-item-action" aria-current="true">
            내가 쓴 글
        </a>
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'comment']) }}" class="list-group-item list-group-item-action">내가 쓴 댓글</a>
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'scrap']) }}" class="list-group-item list-group-item-action">스크랩</a>
    </div>
</div>
<div class="collapse" id="header-list" style="z-index:1055; position:absolute; width:100vw;">
    <div class="list-group">
        <!--name-->
        <a class="fw-bold flex-container disabled list-group-item list-group-item-action"><p>{{ auth()->user()->name }} ( {{ auth()->user()->grade->name }} )</p></a>
        <!--coin-->
        <a class="fw-bold flex-container disabled list-group-item list-group-item-action"><p>{{ coin_transform() }} Coin</p></a>
        <!--mypage-->
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'post']) }}" class="fw-bold flex-container list-group-item list-group-item-action"><p>마이 페이지</p></a>
        <!--Channels-->
        <div class="accordion list-group-item list-group-item-action" id="accordionExample">
            <div class="">
                <div class="accordion-header">

                    <button class="fw-bold flex-container" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_channelJoins" aria-expanded="true" aria-controls="collapseOne">
                        내 동아리
                    </button>
                </div>
            </div>
        </div>
        <div id="collapse_channelJoins" class="accordion-collapse collapse accordion show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                @foreach(auth()->user()->channelJoins as $joined)
{{--                    <a style="padding-left: 30px;" href="{{ route('channel.show', $joined->channel->id) }}" class="flex-container list-group-item list-group-item-action"><img src="{{ asset('image/scrap_c.png') }}" alt="" class="header-list-icon"><p>{{ $joined->channel->name }}</p></a>--}}
                    <a style="padding-left: 30px;" href="{{ route('channel.show', $joined->channel->id) }}" class="flex-container list-group-item list-group-item-action"><p>{{ $joined->channel->name }}</p></a>
                @endforeach
        </div>
        <a href="{{ route('user.logout') }}" class="fw-bold flex-container list-group-item list-group-item-action"><p>로그아웃</p></a>
    </div>
</div>
<div class="collapse" id="header-noti" style="z-index:1055; position:absolute; width:100vw">
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

<div class="list-group" id="header-search" style="z-index:1055; position:fixed; left:10%; top:6.5%; width:30%">
</div>
