@section('mobile.content-mypage')
    <ul class="tab_title accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
{{--        {{ (isset($user)) ? $user->name:'실시간 화제글'  }}--}}
        마이페이지

{{--        @if(isset($user) && auth()->id()==$user->id)--}}
{{--            <span style="margin-left: 10%; color: black !important;">--}}
{{--                <button onclick="location.href='{{ route('user.modify', $user->id) }}'" class="">수정</button>--}}
{{--                <button onclick="deleteChannel({{ $user->id }})" class="">삭제</button>--}}
{{--            </span>--}}
{{--        @endif--}}
    </ul>
    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body-channelinfo">
            @yield('info')
        </div>
    </div>
    <ul class="tab">
        <li value="post" @if( $el =="post") class="on" @endif><a href="{{ route('user.show', ['user'=>$user->id, 'el'=>'post']) }}">나의 쓴 글</a></li>
        <li value="comment" @if( $el =="comment") class="on" @endif><a href="{{ route('user.show', ['user'=>$user->id, 'el'=>'comment']) }}">나의 쓴 댓글</a></li>
        <li value="scrap" @if( $el =="scrap") class="on" @endif><a href="{{ route('user.show', ['user'=>$user->id, 'el'=>'scrap']) }}">나의 스크랩</a></li>
    </ul>
@endsection

@section('mobile.message')
    @if($el == "post")
        작성하신 글이 없어요 !
    @elseif($el == "comment")
        작성하신 댓글이 없어요 !
    @else
        스크랩하신 글이 없어요 !
    @endif
@endsection
