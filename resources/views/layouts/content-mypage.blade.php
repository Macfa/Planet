@section('content-mypage')
<ul class="tab_title">
    활동이력
    <div class="unread" id="unread">
        @if (Cookie::get('unread') == '1') 읽은 글 보기
        @else
            읽은 글 숨기기
        @endif
        </div>
</ul>
<ul class="tab">
    <li value="post" @if( $el =="post") class="on" @endif><a href="{{ route('user.show', ['user'=>$user->id, 'el'=>'post']) }}">나의 쓴 글</a></li>
    <li value="comment" @if( $el =="comment") class="on" @endif><a href="{{ route('user.show', ['user'=>$user->id, 'el'=>'comment']) }}">나의 쓴 댓글</a></li>
    <li value="scrap" @if( $el =="scrap") class="on" @endif><a href="{{ route('user.show', ['user'=>$user->id, 'el'=>'scrap']) }}">나의 스크랩</a></li>
    <li value="channel" @if( $el =="channel") class="on" @endif><a href="{{ route('user.show', ['user'=>$user->id, 'el'=>'channel']) }}">나의 토픽</a></li>
</ul>
@endsection

@section('message')
    @if($el == "post")
        작성하신 글이 없어요
    @elseif($el == "comment")
        작성하신 댓글이 없어요
    @else
        즐겨찾기 한 게시판이 없습니다
    @endif
@endsection
