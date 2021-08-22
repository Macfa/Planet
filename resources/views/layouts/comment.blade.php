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

@if(!blank($comments))
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

                        @if(auth()->id()==$comment->userID)
                            <div class="ml-20 comment-modi-form">
                                <button onclick="editComment({{ $comment->id }})">
                                    <div class="function-text">
                                        <p>수정</p>
                                    </div>
                                </button>
                                <button onclick="deleteComment({{ $comment->id }})">
                                    <div class="function-text">
                                        <p>삭제</p>
                                    </div>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="comment-info">
                        <ul>
                            <li>스탬프</li>
                            <li class="clickable" onclick="replyCommentForm({{ $comment->group }}, {{ $post->id }}, {{ $comment->id }});">댓글</li>
                            <li class="clickable">
                                <img onclick="voteLikeInComment({{ $comment->id }}, 1)" id="comment-upvote" class="image-sm" alt="" src="{{ asset('image/upvote.png') }}" />
                            </li>
                            <li>
                                <span class="comment-like">{{ $comment->likes->sum('like') }}</span>
                            </li>
                            <li class="clickable">
                                <img onclick="voteLikeInComment({{ $comment->id }}, -1)" id="comment-downvote" class="image-sm" src="{{ asset('image/downvote.png') }}" alt="" />
                            </li>

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

</div>
@endif

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

        var dataArray = $(obj).serializeArray(),
            data = {};
        $(dataArray).each(function(i, field){
            data[field.name] = field.value;
        });


        if(data['content'] === "" ) { // 0 : postID, 1 : content
            data['content'] = "내용이 없습니다";
        }

        // console.log(data);return;

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
                if(err.responseJSON.reason == 'login') {
                    alert("로그인이 필요한 기능입니다.");
                } else {
                    alert("댓글이 저장되지않았습니다\n관리자에게 문의해주세요.");
                }
                console.log(err);
            }
        })
    }
    function voteLikeInComment(id, vote, obj) {
        $.ajax({
            url: "/comment/voteLikeInComment",
            data: { id: id, vote:vote },
            type: "post",
            success: function(data) {
                var el = ".comment-"+id+" .comment-like";
                commentClearVote();
                commentSelectVote(data.vote);
                $(el).text(data.vote);
                // alert("처리되었습니다.");
            }
        });
    }
    function commentClearVote() {
        $("#comment-downvote").attr("src", "{{ asset('image/downvote.png') }}");
        $("#comment-upvote").attr("src", "{{ asset('image/upvote.png') }}");
    }
    function commentSelectVote(vote) {
        if(vote == 1) {
            $("#comment-upvote").attr("src", "{{ asset('image/upvote_c.png') }}");
        } else if(vote == -1) {
            $("#comment-downvote").attr("src", "{{ asset('image/downvote_c.png') }}");
        }
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
                            <img onclick="voteLikeInComment(${id}, 1, this)" src="{{ asset('image/square-small.png') }}" alt="" />
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
                            <button onclick="deleteComment(${id})">
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
