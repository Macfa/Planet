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
                                <li class="items">
                                    <img onclick="voteLikeInPost({{ $post->id }},1)" class="image-sm" src="{{ asset('image/upvote.png') }}" alt="" />
                                </li>
                                <li class="items">
{{--                                    <div class="function-text post-like">--}}
                                        <p>{{ $post->likes->sum('vote') }}</p>
{{--                                    </div>--}}
                                </li>
                                <li class="items">
                                    <img onclick="voteLikeInPost({{ $post->id }}, -1)" class="image-sm" src="{{ asset('image/downvote.png') }}" alt="" />
                                </li>
                                <li class="items">
                                    <img src="{{ asset('image/stamp.png') }}" class="image-sm" alt="" />

                                    <div class="function-text">
                                        <p>스탬프</p>
                                    </div>
                                </li>
                                <li class="items">
                                    <img src="{{ asset('image/share.png') }}" class="image-sm" alt="" />

                                    <div class="function-text">
                                        <p>공유</p>
                                    </div>
                                </li>
                                <li class="clickable items" onclick="scrapPost({{ $post->id }})">
                                    <img src="{{ asset('image/scrap.png') }}" class="image-sm" alt="" />

                                    <div class="function-text">
                                        <p>스크랩</p>
                                    </div>
                                    {{-- <scrap-template></scrap-template> --}}
                                </li>
                                <li class="clickable items" onclick="reportPost({{ $post->id }})">
                                    <img src="{{ asset('image/report.png') }}" class="image-sm" alt="" />

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
                                    <img onclick="voteLikeInPost({{ $post->id }},1)" src="{{ asset('image/arrow2-top.png') }}" alt="위로">
                                    <span class="post-like">{{ $post->likes->sum('vote') }}</span>
                                    <img onclick="voteLikeInPost({{ $post->id }},-1)" src="{{ asset('image/arrow2-bot.png') }}" alt="아래로">
                                </div>

                                <img src="{{ asset('image/stamp_c.png') }}" alt="stamp" class="stamp-image image-m">
                                <img class="clickable" onclick="scrapPost({{ $post->id }})" src="{{ asset('image/favorit.png') }}" alt="favorit" class="favorit-image">
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
                            $(".post-like").text(data.vote);
                        },
                        error: function(err) {
                            alert("추천기능에 문제가 생겨 확인 중입니다.");
                        }
                    });
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
                                    alert("스크랩되었습니다");
                                } else if(data.result == "delete") {
                                    alert("스크랩이 삭제되었습니다");
                                }
                            },
                            errror: function(err) {
                                alert("기능에러로 스크랩되지 않았습니다.");
                            }
                        });
                    }
                }
            </script>
@endsection
