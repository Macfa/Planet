@section('content-mainmenu')
    <ul class="tab_title">
        {{ (isset($channel)) ? $channel->name:'포디엄' }}
    </ul>
    <ul class="tab">
        <li class="on clickable realtime" value="realtime" onclick="clickMainMenu('realtime');"><a>실시간</a></li>
        <li class="clickable hot" value="hot" onclick="clickMainMenu('hot');"><a>인기</a></li>
    </ul>
@endsection

@section('message')
    글이 존재하지 않아요 !
@endsection
