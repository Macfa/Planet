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
                    <button type="submit" onclick="addComment();">등록</button>
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
                        <p>{{ $comment->updated_at->diffForHumans() }}</p>

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
                                <img onclick="voteLikeInComment({{ $comment->id }}, 1)" id="comment-{{ $comment->id }}-upvote" class="image-sm" alt=""
                                     @if($comment->existCommentLike == 1)
                                         src="{{ asset('image/upvote_c.png') }}" />
                                    @else
                                        src="{{ asset('image/upvote.png') }}" />
                                    @endif
                            </li>
                            <li>
                                <span class="comment-like">{{ $comment->likes->sum('vote') }}</span>
                            </li>
                            <li class="clickable">
                                <img onclick="voteLikeInComment({{ $comment->id }}, -1)" id="comment-{{ $comment->id }}-downvote" class="image-sm" alt=""
                                     @if($comment->existCommentLike == -1)
                                         src="{{ asset('image/downvote_c.png') }}" />
                                    @else
                                        src="{{ asset('image/downvote.png') }}" />
                                    @endif
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
    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    function deleteComment(id) {
        if(confirm('삭제하시겠습니까 ?')) {
            $.ajax({
                type: "DELETE",
                url: "/comment/"+id,
                data:{"id": id},
                success: function(data) {
                    var el = '.comment-'+id;
                    $(el).remove();
                    var commentTotalCount = $(".comment-list").length;
                    if(commentTotalCount === 0) {
                        $("#comment").remove();
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
        return false;
    }

    function editComment(commentID) {
        var el = ".comment-"+commentID+" .comment-item";
        var el_header = el + ' > .comment-top .comment-modi-form, '+ el + ' > .comment-top .comment-info';
        var el_content = el + ' > .comment-cont';

        // if($(temp_el).length > 0) {
        //     cancleReply(commentID);
        //     return false;
        // }
        var valueList = {
            "commentID": commentID
        };
        $(el_header).hide();
        $(el_content).hide();
        $("#editForm").tmpl(valueList).appendTo(el);
    }

    function cancleEdit(commentID) {
        var el = ".comment-"+commentID+" .comment-item";
        var el_header = el + ' > .comment-top .comment-modi-form, '+ el + ' > .comment-top .comment-info';
        var el_content = el + ' > .comment-cont';
        var el_edit = ".comment-"+commentID+" .comment-item .reply-form";
        $(el_edit).remove();
        $(el_header).show();
        $(el_content).show();
    }
    function updateComment(commentID) {
        var obj = "#comment-edit-form-" + commentID;
        var data = $(obj).serialize();

        delay(function() {
            $.ajax({
                url: "/comment/"+commentID,
                data: data,
                type: "PUT",
                success: function(data) {
                    var valueList = {
                        "id": data.id,
                        "depth": data.depth*44,
                        "updated_at_modi": data.updated_at_modi,
                        "group": data.group,
                        "content": data.content,
                        "sumOfVotes": data.sumOfVotes,
                        "postID": data.postID,
                        "avatar": data.user.avatar,
                        "commentCount": data.commentCount,
                        "name": data.user.name
                    };
                    if(data.commentCount < 2) { // 첫번째 글일 때, 댓글보기 헤더 추가
                        $("#replyForm").tmpl(valueList).insertAfter('.comment-write-form');
                    } else { // 첫번쨰 글이 아닌 경우 그냥 추가
                        $("#replyForm").tmpl(valueList).insertAfter(el);
                    }

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
        }, 300);
    }

    function addComment(commentID) {
        var obj = '';
        var el = '';
        if(commentID) { // 대댓글
            obj = "#comment-form-" + commentID;
            el = ".comment-" + commentID;
        } else { // 댓글
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

        delay(function() {
            $.ajax({
                url: "/comment",
                data: data,
                type: "post",
                success: function(data) {
                    var valueList = {
                        "id": data.id,
                        "depth": data.depth*44,
                        "updated_at_modi": data.updated_at_modi,
                        "group": data.group,
                        "content": data.content,
                        "sumOfVotes": data.sumOfVotes,
                        "postID": data.postID,
                        "avatar": data.user.avatar,
                        "commentCount": data.commentCount,
                        "name": data.user.name
                    };
                    if(data.commentCount < 2) { // 첫번째 글일 때, 댓글보기 헤더 추가
                        $("#replyForm").tmpl(valueList).insertAfter('.comment-write-form');
                    } else { // 첫번쨰 글이 아닌 경우 그냥 추가
                        $("#replyForm").tmpl(valueList).insertAfter(el);
                    }

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
        }, 300);
    }
    function voteLikeInComment(id, vote, obj) {
        $.ajax({
            url: "/comment/voteLikeInComment",
            data: { id: id, vote:vote },
            type: "post",
            success: function(data) {
                var el = ".comment-"+id+" .comment-like";
                commentClearVote(id);
                commentSelectVote(id, data.vote);
                $(el).text(data.totalVote);
                // alert("처리되었습니다.");
            }
        });
    }
    function commentClearVote(id) {
        $("#comment-"+id+"-downvote").attr("src", "{{ asset('image/downvote.png') }}");
        $("#comment-"+id+"-upvote").attr("src", "{{ asset('image/upvote.png') }}");
    }
    function commentSelectVote(id, vote) {
        if(vote == 1) {
            $("#comment-"+id+"-upvote").attr("src", "{{ asset('image/upvote_c.png') }}");
        } else if(vote == -1) {
            $("#comment-"+id+"-downvote").attr("src", "{{ asset('image/downvote_c.png') }}");
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
<script id="editForm" type="text/x-jquery-tmpl">
<div class="reply-form">
    <form method="post" onSubmit="return false;" id="comment-edit-form-${commentID}">
    <div class="reply-input">
        <textarea
        name="content"
        id="reply_text"
        ></textarea>

        <div class="form-btn">
            <div class="reset-btn">
                <button onclick="cancleEdit(${commentID})" type="reset">취소</button>
            </div>

            <div class="write-btn">
                <button type="submit" onclick="updateComment(${commentID}, this);">등록</button>
            </div>
        </div>
    </div>
</form>
</div>
</script>
<script id="replyForm" type="text/x-jquery-tmpl">
@{{if commentCount < 2}}
<div class="comment-list-parent" id="comment">
    <div class="section-title">
        <h4>댓글 보기</h4>
    </div>
    @{{/if}}
   <div class="comment-list comment-${id}">
        <div style="padding-left:${depth}px;" class="comment-item">
            <div class="comment-top">
                <div style="" class="write-info">
                    <img src="${avatar}" alt="닉네임" />
                    <h5 class="nickname">${name}</h5>
                    <p>${updated_at_modi}</p>
                    <div class="ml-20 comment-modi-form">
                        <button onclick="editComment(${id})">
                            <div class="function-text">
                                <p>수정</p>
                            </div>
                        </button>
                        <button onclick="deleteComment(${id})">
                            <div class="function-text">
                                <p>삭제</p>
                            </div>
                        </button>
                    </div>
                </div>

                <div class="comment-info">
                    <ul>
                        <li>스탬프</li>
                        <li onclick="replyCommentForm(${group}, ${postID}, ${id});">댓글</li>
                        <li>
                            <img onclick="voteLikeInComment(${id}, 1)" id="comment-${$id}-upvote" class="image-sm" alt="" src="{{ asset('image/upvote.png') }}" />
                        </li>
                        <li><span class="comment-like">${sumOfVotes}</li>
                        <li><img onclick="voteLikeInComment(${id}, -1)" id="comment-${$id}-downvote" class="image-sm" alt="" src="{{ asset('image/upvote.png') }}" /></li>
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
    @{{if commentCount < 2}}
</div>
@{{/if}}
</script>
<script id="replyWriteForm" type="text/x-jquery-tmpl">
<div class="reply-form">
    <form method="post" onSubmit="return false;" id="comment-form-${commentID}">
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
