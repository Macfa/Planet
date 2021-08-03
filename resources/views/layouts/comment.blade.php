@section('comment')
<!-- 댓글 작성 폼 -->
<div class="comment-write-form">
    <form method="POST" onSubmit="return false;" id="comment-form">
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
                    <button onclick="addComment();">등록</button>
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
    {{--        @if ($comment->depth == 0)--}}

    <!-- 댓글 리스트 -->
        <div class="comment-list comment-{{ $comment->id }}">
            <div style="padding-left:{{ $comment->depth*44 }}px;" class="comment-item">
                <div class="comment-top">
                    <div style="" class="write-info {{ $comment->depth>0 ? 'write-info-line':'' }}">
                        <img src="{{ $comment->user->avatar }}" alt="닉네임" />
                        <h5 class="nickname">{{ $comment->user->name }}</h5>
                        <p>{{ $comment->created_at->diffForHumans() }}</p>
                    </div>

                    <div class="comment-info">
                        <ul>
                            <li>스탬프</li>
                            <li class="clickable" onclick="replyCommentForm({{ $comment->group }}, {{ $post->id }}, {{ $comment->id }});">댓글</li>
                            <li class="clickable">
                                <img onclick="voteLikeInComment({{ $comment->id }}, 1)" src="{{ asset('image/square-small.png') }}" alt="" />
                                <span class="comment-like">{{ $comment->likes->sum('like') }}</span>
                            </li>
                            <li class="clickable"><img onclick="voteLikeInComment({{ $comment->id }}, -1)" src="{{ asset('image/square-small.png') }}" alt="" /></li>
                            @if(auth()->id()==$comment->userID)
                                <li>
                                    <button onclick="editComment({{ $comment->id }})">
                                        <div class="function-text">
                                            <p>edit</p>
                                        </div>
                                    </button>
                                </li>
                                <li>
                                    <button onclick="deleteComment({{ $comment->id }})">
                                        <div class="function-text">
                                            <p>delete</p>
                                        </div>
                                    </button>
                                </li>
                            @endif
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

        {{--        @else--}}

        {{--        <div class="comment-list comment-{{ $comment->id }}">--}}
        {{--            <div class="comment-item">--}}
        {{--                <div class="reply-list">--}}
        {{--                    <div class="reply-item">--}}
        {{--                        <div class="reply-top">--}}
        {{--                            <div class="write-info">--}}
        {{--                                <img src="{{ asset('image/square-big.png') }}" alt="닉네임" />--}}
        {{--                                <h5 class="nickname">닉네임</h5>--}}
        {{--                                <p>{{ $comment->created_at->diffForHumans() }}</p>--}}
        {{--                            </div>--}}

        {{--                            <div class="reply-info">--}}
        {{--                                <ul>--}}
        {{--                                    <li>스탬프</li>--}}
        {{--                                    <li onclick="reply({{ $comment->group }}, {{ $post->id }}, {{ $comment->id }});">댓글</li>--}}
        {{--                                    <li>--}}
        {{--                                        <img onclick="commentLikeVote({{ $comment->id }}, 1)" src="{{ asset('image/square-small.png') }}" alt="" />--}}
        {{--                                        <span class="comment-like">{{ $comment->like }}</span>--}}
        {{--                                    </li>--}}
        {{--                                    <li>--}}
        {{--                                        <img onclick="commentLikeVote({{ $comment->id }}, -1)" src="{{ asset('image/square-small.png') }}" alt="" />--}}
        {{--                                    </li>--}}
        {{--                                </ul>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}

        {{--                        <div class="reply-cont">--}}
        {{--                            <p>--}}
        {{--                                {{ $comment->content }}--}}
        {{--                            </p>--}}
        {{--                        </div>--}}
        {{--                        <!-- 답글 작성 폼 -->--}}

        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--        @endif--}}
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

<script>
    function deleteComment(id) {
        if(confirm('삭제하시겠습니까 ?')) {
            $.ajax({
                type: "DELETE",
                url: "/comment/"+id,
                data:{"id": id},
                success: function(data) {
                    var el = '.comment-'+id;
                    $(el).remove();
                    // window.location.href = "/";
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
        return false;
    }

    function editComment(id) {
        alert("준비중");
    }

    function addComment(commentID) {
        var obj = '';
        var el = '';
        if(commentID) {
            obj = "#comment-form-" + commentID;
            el = ".comment-" + commentID;
        } else {
            obj = "#comment-form";
            el = ".section-title";
        }

        var data = $(obj).serialize();
        $.ajax({
            url: "/comment",
            data: data,
            type: "post",
            success: function(data) {
                var valueList = {
                    "id": data.id,
                    "depth": data.depth*44,
                    "created_at_modi": data.created_at_modi,
                    "group": data.group,
                    "content": data.content,
                    "sumOfVotes": data.sumOfVotes,
                    "postID": data.postID,
                    "avatar": data.user.avatar,
                    "name": data.user.name
                };
                $("#replyForm").tmpl(valueList).insertAfter(el);
                $('.commentCount').html(data.commentCount);
                if(commentID) {
                    cancleReply(commentID);
                } else {
                    $("#comment-form #comment_text").val('');
                }
            },
            error: function(err) {
                alert("댓글이 저장되지않았습니다<br/>관리자에게 문의해주세요.");
                console.log(err);
            }
        })
    }
    function voteLikeInComment(id, vote) {
        $.ajax({
            url: "/comment/voteLikeInComment",
            data: { id: id, vote:vote },
            type: "post",
            success: function(data) {
                var el = ".comment-"+id+" .comment-like";
                $(el).text(data.vote);

                // alert("처리되었습니다.");
            }
        });
    }
    function replyCommentForm(group, postID, commentID) {
        var el = ".comment-"+commentID+" .comment-item";
        var temp_el = el + ' .reply-form';

        if($(temp_el).length > 0) {
            cancleReply(commentID);
            return false;
        }
        var hasForm = hasReplyCommentForm();
        var valueList = {
            "group": group,
            "postID": postID,
            "commentID": commentID
        };
        $("#replyWriteForm").tmpl(valueList).appendTo(el);
    }
    function cancleReply(commentID) {
        var el = ".comment-"+commentID+" .comment-item .reply-form";
        $(el).remove();
    }
    function hasReplyCommentForm() {
        var checkExistForm = $(".reply-form").length;

        if(checkExistForm >= 1) {
            $(".reply-form").remove();
            // return true;
        }
    }
</script>
<script id="replyForm" type="text/x-jquery-tmpl">
   <div class="comment-list comment-${id}">
        <div style="padding-left:${depth}px;" class="comment-item">
            <div class="comment-top">
                <div style="" class="write-info">
                    <img src="${avatar}" alt="닉네임" />
                    <h5 class="nickname">${name}</h5>
                    <p>${created_at_modi}</p>
                </div>

                <div class="comment-info">
                    <ul>
                        <li>스탬프</li>
                        <li onclick="replyCommentForm(${group}, ${postID}, ${id});">댓글</li>
                        <li>
                            <img onclick="voteLikeInComment(${id}, 1)" src="{{ asset('image/square-small.png') }}" alt="" />
                            <span class="comment-like">${sumOfVotes}</span>
                        </li>
                        <li><img onclick="voteLikeInComment(${id}, -1)" src="{{ asset('image/square-small.png') }}" alt="" /></li>
                        <li>
                            <button onclick="editComment(${id})">
                                <div class="function-text">
                                    <p>edit</p>
                                </div>
                            </button>
                        </li>
                        <li>
                            <button onclick="deleteComment({id})">
                                <div class="function-text">
                                    <p>delete</p>
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="comment-cont">
                <p>
                    ${content}
                </p>
            </div>
        </div>
    </div>
</script>
<script id="replyWriteForm" type="text/x-jquery-tmpl">
<div class="reply-form">
    <form method="post" onSubmit="return false;" id="comment-form-${commentID}">
        @csrf
    <input type="hidden" name="group" value="${group}">
    <input type="hidden" name="postID" value="${postID}">
    <input type="hidden" name="id" value="${commentID}">
    <div class="reply-input">
        <textarea
        name="content"
        id="reply_text"
        ></textarea>

        <div class="form-btn">
            <div class="reset-btn">
                <button onclick="cancleReply(${commentID})" type="reset">취소</button>
            </div>

            <div class="write-btn">
                <button type="submit" onclick="addComment(${commentID});">등록</button>
            </div>
        </div>
    </div>
</form>
</div>
</script>
@endsection
