
<!-- 댓글 작성 폼 -->
<div class="comment-write-form">
    {{-- <form method="POST" onSubmit="return false;"> --}}
    <form method="POST" action="{{ url('/comment') }}">
        @csrf
        <input type="hidden" name="postID" value="{{ $post->id }}">
        <div class="form-title">
            <h5>댓글 쓰기</h5>
        </div>

        <div class="comment-input">
            <textarea name="content" id="comment_text"></textarea>

            <div class="form-btn">
                <div class="reset-btn">
                    <button type="reset">취소</button>
                </div>

                <div class="write-btn">
                    <button type="submit">등록</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- 댓글 -->
<div class="comment-list-parent" id="comment">
    <div class="section-title">
        <h4>댓글 보기</h4>
    </div>

    @forelse ($comments as $comment)

        @if ($comment->depth == 0)

        <!-- 댓글 리스트 -->
        <div class="comment-list comment-{{ $comment->id }}">
            <div class="comment-item">
                <div class="comment-top">
                    <div class="write-info">
                        <img src="{{ asset('image/square-big.png') }}" alt="닉네임" />
                        <h5 class="nickname">{{ $comment->user->name }}</h5>
                        <p>1분전</p>
                    </div>

                    <div class="comment-info">
                        <ul>
                            <li>스탬프</li>
                            <li onclick="reply({{ $comment->group }}, {{ $post->id }}, {{ $comment->id }});">댓글</li>
                            <li>
                                <img onclick="commentLikeVote({{ $comment->id }}, 1)" src="{{ asset('image/square-small.png') }}" alt="" />
                                <span class="comment-like">{{ $comment->likes_count }}</span>
                            </li>
                            <li><img onclick="commentLikeVote({{ $comment->id }}, -1)" src="{{ asset('image/square-small.png') }}" alt="" /></li>
                        </ul>
                    </div>
                </div>

                <div class="comment-cont">
                    <p>
                        {{ $comment->content }}
                    </p>
                </div>
                <!-- 답글 작성 폼 -->

            </div>
        </div>

        @else

        <div class="comment-list comment-{{ $comment->id }}">
            <div class="comment-item">
                <div class="reply-list">
                    <div class="reply-item">
                        <div class="reply-top">
                            <div class="write-info">
                                <img src="{{ asset('image/square-big.png') }}" alt="닉네임" />
                                <h5 class="nickname">닉네임</h5>
                                <p>1분전</p>
                            </div>

                            <div class="reply-info">
                                <ul>
                                    <li>스탬프</li>
                                    <li onclick="reply({{ $comment->group }}, {{ $post->id }}, {{ $comment->id }});">댓글</li>
                                    <li>
                                        <img onclick="commentLikeVote({{ $comment->id }}, 1)" src="{{ asset('image/square-small.png') }}" alt="" />
                                        <span class="comment-like">{{ $comment->like }}</span>
                                    </li>
                                    <li>
                                        <img onclick="commentLikeVote({{ $comment->id }}, -1)" src="{{ asset('image/square-small.png') }}" alt="" />
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="reply-cont">
                            <p>
                                {{ $comment->content }}
                            </p>
                        </div>
                        <!-- 답글 작성 폼 -->

                    </div>
                </div>
            </div>
        </div>
        @endif
    @empty
    <p>No users</p>
    @endforelse

    <!-- 댓글 리스트 -->
    <div class="comment-list">
        <div class="comment-item">
            <div class="comment-top">
                <div class="write-info">
                    <img src="{{ asset('image/square-big.png') }}" alt="닉네임" />
                    <h5 class="nickname">닉네임</h5>
                    <p>1분전</p>
                </div>

                <div class="comment-info">
                    <ul>
                        <li>스탬프</li>
                        <li>댓글</li>
                        <li>
                            <img src="{{ asset('image/square-small.png') }}" alt="" /> 1111
                        </li>
                        <li><img src="{{ asset('image/square-small.png') }}" alt="" /></li>
                    </ul>
                </div>
            </div>

            <div class="comment-cont">
                <p>
                    댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글
                </p>
            </div>

            <!-- 답글 작성 폼 -->
            <div class="reply-form">
                <form method="post" onSubmit="return false;">
                    <div class="reply-input">
                        <textarea
                        name="reply_text"
                        id="reply_text"
                        ></textarea>

                        <div class="form-btn">
                            <div class="reset-btn">
                                <button type="reset">취소</button>
                            </div>

                            <div class="write-btn">
                                <button type="submit">등록</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="reply-list">
                <div class="reply-item">
                    <div class="reply-top">
                        <div class="write-info">
                            <img src="{{ asset('image/square-big.png') }}" alt="닉네임" />
                            <h5 class="nickname">닉네임</h5>
                            <p>1분전</p>
                        </div>

                        <div class="reply-info">
                            <ul>
                                <li>스탬프</li>
                                <li>댓글</li>
                                <li>
                                    <img src="{{ asset('image/square-small.png') }}" alt="" />
                                    1111
                                </li>
                                <li>
                                    <img src="{{ asset('image/square-small.png') }}" alt="" />
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="reply-cont">
                        <p>
                            댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글댓글
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 하단 기능 -->
<div class="board-bot-function">
    <div class="left-function">
        <div class="page-arrow">
            <img src="{{ asset('image/arrow2-top.png') }}" alt="위로">
            <span class="post-like">{{ $post->likes_count }}</span>
            <img src="{{ asset('image/arrow2-bot.png') }}" alt="아래로">
        </div>

        <img src="{{ asset('image/stamp.png') }}" alt="stamp" class="stamp-image">
        <img src="{{ asset('image/favorit.png') }}" alt="favorit" class="favorit-image">
        <img src="{{ asset('image/message.png') }}" alt="message" class="message-image">
    </div>

    <div class="right-function">
        <img src="{{ asset('image/message.png') }}" alt="message" class="message-image">
    </div>
</div>
