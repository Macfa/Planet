@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/post/show.css') }}">
    <div class="modal-parent">
        <div class="modal-wrap">
            <div class="modal-top">

                <div class="modal-title">
                    <h4>
                        {{ $post->title }}&nbsp;&nbsp;&nbsp;&nbsp;<span class="titleSub">[<span class="commentCount">{{ $post->comments_count }}</span>]</span>
                    </h4>
                </div>

                <div class="write-info">
                    <p><span><a href="{{ route('channel.show', $post->channelID) }}">[{{ $post->channel->name }}]</a></span>&nbsp;온 <a href="{{ route('user.show', 'post') }}">{{ $post->user->name }}</a> / {{ $post->created_at->diffForHumans() }}</p>
                </div>

                <div class="modal-close">
                    <img src="{{ asset('image/close.png') }}" alt="닫기" />
                </div>
            </div>

            <div class="modal-body">
                <!-- 왼쪽 게시글 내용 -->
                <div class="modal-left">
                    <div class="modal-content">
                        <div class="board-text">
                            {!! $post->content !!}
                        </div>

                        <!-- 게시글 기타 기능 -->
                        <div class="board-etc-function" id="post">
                            <ul>
                                <li class="clickable items">
                                    <img id="post-upvote" onclick="voteLikeInPost({{ $post->id }},1)" class="image-sm" alt=""
                                         @if($post->existPostLike == 1)
                                             src="{{ asset('image/upvote_c.png') }}" />
                                        @else
                                            src="{{ asset('image/upvote.png') }}" />
                                        @endif
                                </li>
                                <li class="items">
                                    <div class="post-like">
                                        <p>{{ $post->likes->sum('vote') }}</p>
                                    </div>
                                </li>
                                <li class="clickable items">
                                    <img id="post-downvote" onclick="voteLikeInPost({{ $post->id }}, -1)" class="image-sm" alt=""
                                         @if($post->existPostLike == -1)
                                            src="{{ asset('image/downvote_c.png') }}" />
                                        @else
                                            src="{{ asset('image/downvote.png') }}" />
                                        @endif
                                </li>
                                <li class="clickable items" onclick="stampPost({{ $post->id }});">
                                    <img src="{{ asset('image/stamp.png') }}" class="image-sm" alt="" />

                                    <div class="function-text">
                                        <p>스탬프</p>
                                    </div>
                                </li>
                                <li class="clickable items">
                                    <img src="{{ asset('image/share.png') }}" class="image-sm" alt="" />

                                    <div class="function-text">
                                        <p>공유</p>
                                    </div>
                                </li>
                                <li class="clickable items" onclick="scrapPost({{ $post->id }})">
                                    <img class="image-sm" name="scrap" alt=""
                                         @if($post->existPostScrap == 1)
                                             src="{{ asset('image/scrap_c.png') }}" />
                                        @else
                                             src="{{ asset('image/scrap.png') }}" />
                                        @endif

                                    <div class="function-text">
                                        <p>스크랩</p>
                                    </div>
                                    {{-- <scrap-template></scrap-template> --}}
                                </li>
                                <li class="clickable items" onclick="reportPost({{ $post->id }})">
                                    <img class="image-sm" alt=""
                                         @if($post->existPostReport == 1)
                                            src="{{ asset('image/report_c.png') }}" />
                                        @else
                                            src="{{ asset('image/report.png') }}" />
                                        @endif

                                    <div class="function-text">
                                        <p>신고</p>
                                    </div>
                                </li>
                                @if(auth()->id()==$post->userID)
                                    <div class="ml-a items-r">
                                        <li class="clickable items-r" onclick="location.href='{{ route('post.edit', $post->id) }}'">
                                            <div class="function-text">
                                                <p>수정</p>
                                            </div>
                                        </li>
                                        <li class="clickable " onclick="deletePost({{ $post->id }})">
                                            <div class="function-text">
                                                <p>삭제</p>
                                            </div>
                                        </li>
                                    </div>
                                @endif
                            </ul>
                        </div>

                    {{--                    @extends('layouts.comment')--}}
                    @yield('comment')


                    <!-- 하단 기능 -->
                        <div class="board-bot-function">
                            <div class="left-function">
                                <div class="page-arrow">
                                    <img onclick="voteLikeInPost({{ $post->id }},1)" id="post-upvote-fix" class="image-m" alt="위로"
                                         @if($post->existPostLike == 1)
                                             src="{{ asset('image/upvote_c.png') }}" />
                                        @else
                                            src="{{ asset('image/upvote.png') }}" />
                                        @endif
                                    <span class="post-like">{{ $post->likes->sum('vote') }}</span>
                                    <img onclick="voteLikeInPost({{ $post->id }},-1)" id="post-downvote-fix" class="image-m" alt="아래로"
                                         @if($post->existPostLike == -1)
                                             src="{{ asset('image/downvote_c.png') }}" />
                                        @else
                                            src="{{ asset('image/downvote.png') }}" />
                                        @endif
                                </div>

                                <img alt="stamp" class="stamp-image image-m" src="{{ asset('image/stamp.png') }}"/>
                                <img class="favorit-image image-m clickable" id="post-scrap" onclick="scrapPost({{ $post->id }})" alt="favorit"
                                     @if($post->postScrap == 1)
                                         src="{{ asset('image/scrap_c.png') }}" />
                                    @else
                                        src="{{ asset('image/scrap.png') }}" />
                                    @endif
                                <img src="{{ asset('image/message.png') }}" alt="message" class="message-image">
                            </div>

                            <div class="right-function">
                                <img src="{{ asset('image/message.png') }}" alt="message" class="message-image">
                            </div>
                        </div>

                    <!-- 오른쪽 광고배너 -->
{{--                        <div class="modal-right">--}}
{{--                            <div class="modal-banner">--}}
{{--                                <div class="banner-item">--}}
{{--                                    <h3>광고 배너</h3>--}}
{{--                                </div>--}}

{{--                                <div class="banner-item">--}}
{{--                                    <h3>광고 배너</h3>--}}
{{--                                </div>--}}

{{--                                <div class="banner-item">--}}
{{--                                    <h3>광고 배너</h3>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
            {{--    <script src="{{ asset('js/editorShow.js') }}"></script>--}}
            <script>
                document.querySelectorAll( 'oembed[url]' ).forEach( element => {
                    // Create the <a href="..." class="embedly-card"></a> element that Embedly uses
                    // to discover the media.
                    const anchor = document.createElement( 'a' );

                    anchor.setAttribute( 'href', element.getAttribute( 'url' ) );
                    anchor.className = 'embedly-card';

                    element.appendChild( anchor );
                } );

                function deletePost(id) {
                    if(confirm('삭제하시겠습니까 ?')) {
                        $.ajax({
                            type: "DELETE",
                            url: "/post/"+id,
                            data:{"id": id},
                            success: function(data) {
                                window.location.href = "/";
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        })
                    }
                    return false;
                }
                function voteLikeInPost(id, vote) {
                    $.ajax({
                        url: "/post/voteLikeInPost",
                        data: { id: id, vote:vote },
                        type: "post",
                        success: function(data) {
                            // console.log(data);
                            clearVote();
                            selectVote(data.vote);
                            $(".post-like").text(data.totalVote);
                        },
                        error: function(err) {
                            alert("추천기능에 문제가 생겨 확인 중입니다.");
                        }
                    });
                }
                function clearVote() {
                    $("#post-downvote, #post-downvote-fix").attr("src", "{{ asset('image/downvote.png') }}");
                    $("#post-upvote, #post-upvote-fix").attr("src", "{{ asset('image/upvote.png') }}");
                }
                function selectVote(vote) {
                    if(vote == 1) {
                        $("#post-upvote, #post-upvote-fix").attr("src", "{{ asset('image/upvote_c.png') }}");
                    } else if(vote == -1) {
                        $("#post-downvote, #post-downvote-fix").attr("src", "{{ asset('image/downvote_c.png') }}");
                    }
                }
                function reportPost(postID) {
                    $.ajax({
                        url: "/post/reportPost",
                        data: { id: postID },
                        type: "post",
                        success: function(data) {
                            alert("신고되었습니다");
                        },
                        errror: function(err) {
                            alert("기능에러로 신고되지 않았습니다.");
                        }
                    });
                }
                function scrapPost(postID) {
                    if(confirm('스크랩하시겠습니까?\n기존에 스크랩을 했었다면 스크랩이 삭제됩니다')) {
                        $.ajax({
                            url: "/post/scrapPost",
                            data: { id: postID },
                            type: "post",
                            success: function(data) {
                                if(data.result == "insert") {
                                    $("#post-scrap").attr("src", "{{ asset('image/scrap_c.png') }}");
                                    alert("스크랩되었습니다");
                                } else if(data.result == "delete") {
                                    $("#post-scrap").attr("src", "{{ asset('image/scrap.png') }}");
                                    alert("스크랩이 삭제되었습니다");
                                }
                            },
                            errror: function(err) {
                                alert("기능에러로 스크랩되지 않았습니다.");
                            }
                        });
                    }
                }

                function stampPost() {
                    var options = 'width=500, height=600, top=30, left=30, resizable=no, scrollbars=no, location=no';
                    // window.open('https://naver.com', '', options);
                    window.location.assign('https://naver.com', '', options);

                    // 출처: https://mine-it-record.tistory.com/304 [나만의 기록들]
                    // 출처: https://mine-it-record.tistory.com/304 [나만의 기록들]
                    // var options = "top=100,left=200,width=200,height=200,centerscreen=yes,resizable=no,scrollbars=yes";
                    // window.open("https://naver.com", '_blank', options);
                }
            </script>
@endsection
