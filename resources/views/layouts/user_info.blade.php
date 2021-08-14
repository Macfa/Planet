@section('info')
<div class="right">
    <div class="right_sub">
        <div class="info">
            마이페이지
        </div>
        <div class="info_detail">
{{--            <div class="flex">--}}
{{--                <div class="flex_item">--}}
{{--                    <div><img style="width:36px; height:36px;" src="{{ $user->avatar }}"/>ID : {{ $user->name }}</div>--}}
{{--                </div>--}}
{{--                <div class="flex_item">--}}
{{--                    <div>버튼</div>--}}
{{--                    <p>포인트 필수</p>--}}
{{--                </div>--}}
{{--            </div>--}}
                <div class="">
                    <img style="float: left; width:42px; height:42px;" src="{{ $user->avatar }}"/>
                    <div style="margin-left: 45px;">
                        <span>
                            ID : {{ $user->name }}&nbsp;&nbsp;&nbsp;&nbsp;<button class="sub_btn" onclick="modifyUserName();">변경</button>
                        </span>
                        <br/>
                        <span>
                            등급 : 등급
                        </span>
                    </div>
{{--                <div class="flex_item">--}}
{{--                    <div>버튼</div>--}}
{{--                    <p>포인트 필수</p>--}}
{{--                </div>--}}
{{--                <div class="flex_item">--}}

{{--                </div>--}}
            </div>
            <div id="progressbar">

            </div>
            <div class="flex">
                <div class="flex_item">
                    <div>{{ date_format($user->created_at, 'Y년 m월 d일') }}</div>
                    <p>생성일자</p>
                </div>
                <div class="flex_item">
                    {{-- <div>{{ $post->created_at->format('Y-m-d') }}</div> --}}
                    <div>{{ number_format($coin->totalCoin) }}</div>
                    <p>보유코인</p>
                </div>
            </div>
            <div class="flex">
                <div class="flex_item">
                    <div>{{ $coin->postCount }}</div>
                    <p>게시글 수</p>
                </div>
                <div class="flex_item">
                    <div>{{ number_format($coin->postCoin) }}</div>
                    <p>대자보 등극 게시글 수</p>
                </div>
            </div>
            <div class="flex">
                <div class="flex_item">
                    <div>{{ $coin->commentCount }}</div>
                    <p>댓글 수</p>
                </div>
                <div class="flex_item">
                    <div>{{ number_format($coin->commentCoin) }}</div>
                    <p>베스트 댓글 수</p>
                </div>
            </div>
{{--            <div class="flex">--}}
{{--                <li class="flex_item">--}}
{{--                    <a href="{{ route('channel.edit', $channel->id) }}">수정</a>--}}
{{--                </li>--}}
{{--                <li class="flex_item">--}}
{{--                    <form action="{{ route('channel.destroy', $channel->id) }}" method="post">--}}
{{--                        @csrf--}}
{{--                        @method('delete')--}}
{{--                        <button type="submit">--}}
{{--                            삭제--}}
{{--                            --}}{{--                            <a>삭제</a>--}}
{{--                        </button>--}}
{{--                    </form>--}}
{{--                </li>--}}
{{--            </div>--}}
        </div>
    </div>
    <div class="link">
        <p>사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.</p>
        <p>어쩌면 마음이 맞는 친구를 찾을지도 모릅니다.</p>
        <ul>
            <li><a href="{{ route('post.create') }}">게시글 작성</a></li>
            <li><a href="{{ route('channel.create') }}">몽드 만들기</a></li>
        </ul>
    </div>
</div>

<div class="modalLayer">
    <div class="modalHeader">
        <div class="Header">
            <p>변경할 ID를 입력하세요</p>
        </div>
    </div>
    <div class="modalFooter">
        <div class="Body">
            <input type="text">
        </div>
        <div class="Footer">
            <div class="left">
                <img alt="img">
                <span> 100 차감</span>
            </div>
            <div class="right">
                <button>취소</button>
                <button>등록</button>
            </div>
        </div>
    </div>
</div>
    <script>
        $("#progressbar").progressbar({
            classes: {
                "ui-progressbar": "highlight"
            },
            value: false
        });
        function modifyUserName() {
            var popupWidth = 500;
            var popupHeight = 200;
            var popupX = (window.screen.width / 2) - (popupWidth / 2);
            // 만들 팝업창 width 크기의 1/2 만큼 보정값으로 빼주었음

            var popupY= (window.screen.height / 2) - (popupHeight / 2);
            // 만들 팝업창 height 크기의 1/2 만큼 보정값으로 빼주었음
            $(".modalLayer").fadeIn("slow");
            $(".modalLayer").css('width', popupWidth);
            $(".modalLayer").css('height', popupHeight);
            $(".modalLayer").css('left', popupX);
            $(".modalLayer").css('top', popupY);
            $(".modalLayer").css('position', 'absolute');
        }
    </script>
@endsection
