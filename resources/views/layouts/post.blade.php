@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/post/show.css') }}">
    <div class="modal-parent">
        <div class="modal-wrap">
            <div class="modal-top">
                <div class="modal-page">
                    <div class="arrow-top">
                        <img onclick="voteLikeInPost({{ $post->id }},1)" src="{{ asset('image/arrow-top.png') }}" alt="앞으로" />
                    </div>

                    <span class="now-page post-like">{{ $post->likes->sum('like') }}</span>

                    <div class="arrow-bot">
                        <img onclick="voteLikeInPost({{ $post->id }},-1)" src="{{ asset('image/arrow-bot.png') }}" alt="뒤로" />
                    </div>
                </div>

                <div class="modal-title">
                    <h4>
                        {{ $post->title }} [{{ $post->comments_count }}]
                    </h4>
                </div>

                <div class="write-info">
                    <p><span><a href="{{ route('channel.show', $post->channelID) }}">[{{ $post->channel->name }}]</a></span>온 <a href="{{ route('user.show', 'post') }}">{{ $post->user->name }}</a> / {{ $post->created_at->diffForHumans() }}</p>
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
                                <li>
                                    <img onclick="voteLikeInPost({{ $post->id }},1)" src="{{ asset('image/square-small.png') }}" alt="" />

                                    <div class="function-text post-like">
                                        <p>{{ $post->likes->sum('like') }}</p>
                                    </div>
                                </li>
                                <li>
                                    <img onclick="voteLikeInPost({{ $post->id }}, -1)" src="{{ asset('image/square-small.png') }}" alt="" />
                                </li>
                                <li>
                                    <img src="{{ asset('image/square-small.png') }}" alt="" />

                                    <div class="function-text">
                                        <p>스탬프</p>
                                    </div>
                                </li>
                                <li>
                                    <img src="{{ asset('image/square-small.png') }}" alt="" />

                                    <div class="function-text">
                                        <p>공유</p>
                                    </div>
                                </li>
                                <li>
                                    <img src="{{ asset('image/square-small.png') }}" alt="" />

                                    <div class="function-text">
                                        <p>스크랩</p>
                                    </div>
                                    {{-- <scrap-template></scrap-template> --}}
                                </li>
                                <li>
                                    <img src="{{ asset('image/square-small.png') }}" alt="" />

                                    <div class="function-text">
                                        <p>신고</p>
                                    </div>
                                </li>
                                @if(auth()->id()==$post->userID)
                                <li>
                                    <a href="{{ route('post.edit', $post->id) }}">
                                        <div class="function-text">
                                            <p>edit</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('post.destroy', $post->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button>
                                            <div class="function-text">
                                                <p>delete</p>
                                            </div>
                                        </button>
                                    </form>
                                </li>
                                @endif
                            </ul>
                        </div>

                    {{--                    @extends('layouts.comment')--}}
                    @yield('comment')

                    <!-- 오른쪽 광고배너 -->
                        <div class="modal-right">
                            <div class="modal-banner">
                                <div class="banner-item">
                                    <h3>광고 배너</h3>
                                </div>

                                <div class="banner-item">
                                    <h3>광고 배너</h3>
                                </div>

                                <div class="banner-item">
                                    <h3>광고 배너</h3>
                                </div>
                            </div>
                        </div>
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

                function voteLikeInPost(id, vote) {
                    $.ajax({
                        url: "/post/voteLikeInPost",
                        data: { id: id, vote:vote },
                        type: "post",
                        success: function(data) {
                            $(".post-like").text(data.vote);
                        }
                    });
                }
                function deletePost(id) {
                    $.ajax({
                        url: "/post/destroy",
                        data: { id: id },
                        method: "DELETE",
                        // type: "post",
                        success: function(data) {
                            window.back();
                        }
                    })
                }
            </script>
@endsection
