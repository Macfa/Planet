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
                    <img style="float: left; width:45px;" src="{{ $user->avatar }}"/>
                    <div style="margin-left: 50px;">
                        <span>
                            ID : {{ $user->name }}&nbsp;&nbsp;&nbsp;&nbsp;
                            @if(auth()->id() == $user->id)
                            <!-- Button trigger modal -->
{{--                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">--}}
{{--    Launch demo modal--}}
{{--</button>--}}
                                <button type="button" class="sub_btn" data-bs-toggle="modal" data-bs-target="#modalModifyUserName">변경</button>
                            @endif
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
                    {{-- <div>{{ $post->created_at->format('Y-m-d') }}</div> --}}
                    <div>{{ number_format($coin->totalCoin) }}</div>
                    <p>보유코인</p>
                </div>
                <div class="flex_item">
                    <div>{{ date_format($user->created_at, 'Y.m.d') }}</div>
                    <p>생성일자</p>
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
            <li><a href="{{ route('channel.create') }}">동아리 만들기</a></li>
        </ul>
    </div>
</div>

<div class="modalLayer">
    <form method="post" action="{{ route('user.modify', $user->id) }}">
        @csrf
        <div class="modalHeader">
            <div class="Header">
                <p>변경할 ID를 입력하세요</p>
            </div>
        </div>
        <div class="modalFooter">
            <div class="Body">
                <input type="text" name="name" required>
            </div>
            <div class="Footer">
                <div class="left">
                    <img alt="img">
                    <span> 100 차감</span>
                </div>
                <div class="right">
                    <button type="button" onclick="closeModifyUserName();">취소</button>
                    <button type="submit">등록</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="modalModifyUserName" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{ route('user.modify', $user->id) }}" class="needs-validation" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">계정정보 변경</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-3 has-validation">
{{--                        <input type="text" class="form-control" name="name" id="floatingName" placeholder="사용자 이름" minlength="3" maxlength="8" required pattern="^[가-힣,a-z]{3,8}$">--}}
                        <input type="text" class="form-control" name="name" id="floatingName" placeholder="사용자 이름" required pattern="^[가-힣,a-z,1-9]{3,8}$">
                        <label for="floatingName">변경할 유저명를 입력하세요</label>
                        <div class="valid-feedback">
                            가능합니다
                        </div>
                        <div class="invalid-feedback">
                            3 ~ 8자로 한영, 숫자로 이름를 입력해주세요
                        </div>

                    </div>
{{--                    <label for="recipient-name" class="col-form-label">변경할 ID를 입력하세요</label>--}}
{{--                    <input type="text" class="form-control" name="name" placeholder="유저 아이디" aria-label="name">--}}
{{--                    <input type="text" class="form-control" name="name">--}}
{{--                    <input type="text" class="form-control" id="recipient-name">--}}
                </div>
{{--                <div class="modal-footer">--}}
                <div class="modal-header">
                    <div class="left">
                        <img alt="img">
                        @if($user->isNameChanged=="Y")
                            <span> 100 차감</span>
                        @else
                            <span> 차감 없음</span>
                        @endif
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                        <button type="submit" class="btn btn-primary">등록</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
    <script>
        $("#progressbar").progressbar({
            classes: {
                "ui-progressbar": "highlight"
            },
            value: 20
        });
        // function openModifyUserName() {
        //     var popupWidth = 500;
        //     // var popupHeight = 160;
        //     var popupHeight = $(".modalLayer").css("height");
        //     var popupX = (window.screen.width / 2) - (popupWidth / 2);
        //     // 만들 팝업창 width 크기의 1/2 만큼 보정값으로 빼주었음
        //
        //     var popupY= (window.screen.height / 2) - (popupHeight / 2);
        //     // 만들 팝업창 height 크기의 1/2 만큼 보정값으로 빼주었음
        //     $(".modalLayer").fadeIn();
        //     $(".modalLayer").css('width', popupWidth);
        //     $(".modalLayer").css('height', popupHeight);
        //     $(".modalLayer").css('left', popupX);
        //     $(".modalLayer").css('top', popupY);
        //     $(".modalLayer").css('position', 'absolute');
        // }
        // function closeModifyUserName() {
        //     $(".modalLayer").fadeOut();
        // }
        // Example starter JavaScript for disabling form submissions if there are invalid fields
    </script>
@endsection
