{{--@section('header-collaps')--}}
    <div class="collapse" id="header-mypage" style="position:absolute; right:2%; top:6.5%; width:15%">
        <div class="list-group" style="border-radius: 1rem;">
            <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'post']) }}" class="list-group-item list-group-item-action" aria-current="true">
                내가 쓴 글
            </a>
            <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'comment']) }}" class="list-group-item list-group-item-action">내가 쓴 댓글</a>
            <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'scrap']) }}" class="list-group-item list-group-item-action">스크랩</a>
        </div>
    </div>
    <div class="collapse" id="header-list" style="position:absolute; right:2%; top:6.5%; width:15%">
        <div class="list-group" style="border-radius: 1rem;">
            <a href="" class="list-group-item list-group-item-action">Some</a>
            <a href="" class="list-group-item list-group-item-action">Some</a>
            <a href="{{ route('user.logout') }}" class="list-group-item list-group-item-action">로그아웃</a>
        </div>
    </div>
<div class="collapse" id="header-noti" style="position:absolute; right:2%; top:6.5%; width:15%">
    <div class="list-group" style="border-radius: 1rem;">
        @forelse(auth()->user()->notifications as $notification)
            <a href="" class="list-group-item list-group-item-action">{{ $notification->data['msg'] }}</a>
        @empty
            <a href="" class="list-group-item list-group-item-action">알림이 없습니다.</a>
        @endforelse
    </div>
</div>
{{--@endsection--}}

<div class="list-group" id="header-search" style="position:fixed; left:10%; top:6.5%; width:30%">
</div>
