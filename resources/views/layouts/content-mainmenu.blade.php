@section('content-mainmenu')
    <ul class="tab_title">
        {{ (isset($channel)) ? $channel->name:'실시간 화제글' }}
        <div class="unread">
            <button class="unread_white" onclick="toggleUnread();">
                @if (Cookie::get('unread') == '1') 읽은 글 보기
                @else
                    읽은 글 숨기기
                @endif
            </button>
        </div>
    </ul>
    <ul class="tab">
        <li class="on clickable realtime" value="realtime" onclick="clickMainMenu('realtime');"><a>전체</a></li>
        <li class="clickable hot" value="hot" onclick="clickMainMenu('hot');"><a>관심토픽</a></li>
    </ul>
@endsection

@section('message')
    글이 존재하지 않아요 !
@endsection
