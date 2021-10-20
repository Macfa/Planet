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
                    <button type="button" data-bs-dismiss="modal" aria-label="Close">취소</button>
                </div>

                <div class="write-btn">
                    <button type="submit" onclick="@if(auth()->check()) checkCommentTypeToProcess('add'); @else notLogged(); @endif">등록</button>
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
                                <button onclick="checkCommentTypeToAddForm('edit', {{ $comment->id }})">
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
                            <li data-bs-toggle="modal" data-bs-target="#openStampModal" class="clickable items">스탬프</li>
{{--                            <li></li>--}}
                            <li class="clickable" onclick="@if(auth()->check()) checkCommentTypeToAddForm('add', {{ $comment->id }}); @else notLogged(); @endif">댓글</li>
                            <li class="clickable">
                                <img onclick="@if(auth()->check()) voteLikeInComment({{ $comment->id }}, 1) @else notLogged(); @endif" id="comment-{{ $comment->id }}-upvote" class="image-sm" alt=""
                                     @if($comment->existCommentLike == 1)
                                         src="{{ asset('image/upvote_c.png') }}" />
                                    @else
                                        src="{{ asset('image/upvote.png') }}" />
                                    @endif
                            </li>
                            <li>
                                <span class="comment-like">{{ $comment->likes->sum('like') }}</span>
                            </li>
                            <li class="clickable">
                                <img onclick="@if(auth()->check()) voteLikeInComment({{ $comment->id }}, -1) @else notLogged(); @endif" id="comment-{{ $comment->id }}-downvote" class="image-sm" alt=""
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
                        {!! $comment->content !!}
                    </p>
                </div>
            </div>
        </div>
    @empty
        <p>No users</p>
@endforelse
        <!-- 하단 기능 Comment -->
{{--        <div class="board-bot-function" style="position: sticky; bottom:10px;  background: rgba(252, 252, 252, 1) !important;">--}}
        <div class="board-bot-function" id="post-bot-function">
            <div class="left-function">
                <div class="page-arrow">
                    <img onclick="@if(auth()->check()) voteLikeInPost({{ $post->id }},1) @else notLogged(); @endif" id="post-upvote-fix" class="image-m clickable" alt="위로"
                         @if($post->existPostLike == 1)
                         src="{{ asset('image/upvote_c.png') }}" />
                    @else
                        src="{{ asset('image/upvote.png') }}" />
                    @endif
                    <span class="post-like">{{ $post->likes->sum('like') }}</span>
                    <img onclick="@if(auth()->check()) voteLikeInPost({{ $post->id }},-1) @else notLogged(); @endif" id="post-downvote-fix" class="image-m clickable" alt="아래로"
                         @if($post->existPostLike == -1)
                         src="{{ asset('image/downvote_c.png') }}" />
                    @else
                        src="{{ asset('image/downvote.png') }}" />
                    @endif
                </div>

                <img alt="stamp" class="stamp-image image-m clickable" src="{{ asset('image/stamp.png') }}"/>
                <img class="favorit-image image-m clickable" id="post-scrap" onclick="@if(auth()->check()) scrapPost({{ $post->id }}) @else notLogged(); @endif" alt="favorit"
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
    </div>
</div>
@endif

<script>


    // add : 댓글, 대댓글   |   edit : 수정
    function checkCommentTypeToAddForm(commentType, commentID) {
        if(commentType == "edit") {
            checkExistEditForm(commentID);
        } else if(commentType == "add") {
            checkExistAddForm(commentID);
        }
    }
    function checkExistEditForm(commentID) {
        var el = $(".reply-form");

        if(el.length >= 1) {
            // 이미 열려있는 폼의 아이디를 가져온다
            var existCommentID = $(".reply-form input[name='id']").val();
            toggleEditForm('hide', existCommentID);

            // 새로 수정하고하는 댓글의 수정 폼을 연다
            toggleEditForm('show', commentID);
        } else {
            toggleEditForm('show', commentID);
        }
    }
    function toggleEditForm(status, commentID) {
        var el = $(`.comment-info, .comment-modi-form, .comment-cont`, `.comment-${commentID}`);
        if(status == "show") {
            el.hide();

            // var value = escapeHTML($(`.comment-${commentID} .comment-cont p`).html());
            var templateValues = {
                "commentID": commentID,
                "value": "",
                "form": "edit"
            };

            $("#replyWriteForm").tmpl(templateValues).appendTo(`.comment-${commentID} .comment-item`);
        } else if(status == "hide") {
            $(`.comment-${commentID} .reply-form`).remove();
            el.show();
        }
    }
    function checkExistAddForm(commentID) {
        var el = $(".reply-form");

        if(el.length >= 1) {
            // 이미 열려있는 폼의 아이디를 가져온다
            var existCommentID = $(".reply-form input[name='id']").val();
            toggleAddForm('hide', existCommentID);

            // 새로 수정하고하는 댓글의 수정 폼을 연다
            toggleAddForm('show', commentID);
        } else {
            toggleAddForm('show', commentID);
        }
    }
    function toggleAddForm(status, commentID) {
        if(status == "show") {
            var templateValues = {
                "commentID": commentID,
                "value": "",
                "form": "add"
            };

            $("#replyWriteForm").tmpl(templateValues).appendTo(`.comment-${commentID} .comment-item`);
        } else if(status == "hide") {
            $(`.comment-${commentID} .reply-form`).remove();
        }
    }
    function cancleForm(form, commentID) {
        if(form == "edit") {
            toggleEditForm("hide", commentID);
        } else if(form == "add") {
            toggleAddForm("hide", commentID);
        }
    }
    function checkCommentTypeToProcess(form, commentID) {
        // make it one
        if(form == "add") {
            addComment(form, commentID);
        } else if(form == "edit") {
            addComment(form, commentID);
        }
    }
    function addComment(form, commentID) {
        // init variables
        var data = "";
        var type = "";
        var url = "";

        // 댓글, 대댓글 구분
        if(commentID) {
            data = $(`.comment-${commentID} .reply-form form`).serialize();
        } else {
            data = $("#comment-form").serialize();
        }

        // 생성, 수정 구분
        if(form == "add") {
            type = "post";
            url = "/comment";
        } else if(form == "edit") {
            type = "put";
            url = "/comment/" + commentID;
        }
        delay(function() {
            $.ajax({
                url: url,
                data: data,
                type: type,
                success: function(data) {
                    if(form == "edit") { // 기존 댓글 업데이트 로직
                        $(`.comment-${commentID} .comment-cont p`).html(data.content);
                        toggleEditForm('hide', commentID);
                    } else if(form == "add") { // 신규 댓글 생성 로직
                        var templateValues = {
                            "id": data.id,
                            "depth": data.depth*44,
                            "updated_at_modi": data.updated_at_modi,
                            "group": data.group,
                            "content": data.content,
                            "sumOfLikes": data.sumOfLikes,
                            "postID": data.postID,
                            "avatar": data.user.avatar,
                            "commentCount": data.commentCount,
                            "name": data.user.name
                        };

                        if(data.commentCount < 2) { // 첫번째 글일 때, 댓글보기 헤더 추가
                            $("#replyForm").tmpl(templateValues).insertAfter('.comment-write-form');
                        } else { // 첫번쨰 글이 아닌 경우 그냥 추가
                            if(commentID) { // 대댓글
                                $("#replyForm").tmpl(templateValues).insertAfter(`.comment-${commentID}`);
                            } else { // 댓글
                                $("#replyForm").tmpl(templateValues).insertAfter(".section-title");
                            }
                        }
                        $(`#post-${data.postID} .commentCount, #open_post_modal .commentCount`).text(data.commentCount);
                        if(commentID) {
                            cancleForm('add', commentID);
                        } else {
                            $("#comment-form #comment_text").val('');
                        }
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
    function voteLikeInComment(id, like, obj) {
        $.ajax({
            url: "/comment/voteLikeInComment",
            data: { id: id, like:like },
            type: "post",
            success: function(data) {
                var el = ".comment-"+id+" .comment-like";
                commentClearLike(id);
                commentSelectLike(id, data.like);
                $(el).text(data.totalLike);
                // alert("처리되었습니다.");
            }
        });
    }
    function commentClearLike(id) {
        $(`#comment-${id}-downvote`).attr("src", "{{ asset('image/downvote.png') }}");
        $(`#comment-${id}-upvote`).attr("src", "{{ asset('image/upvote.png') }}");
    }
    function commentSelectLike(id, like) {
        if(like == 1) {
            $("#comment-"+id+"-upvote").attr("src", "{{ asset('image/upvote_c.png') }}");
        } else if(like == -1) {
            $("#comment-"+id+"-downvote").attr("src", "{{ asset('image/downvote_c.png') }}");
        }
    }
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
                        <button onclick="checkCommentTypeToAddForm('edit', ${id})">
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
                        <li onclick="checkCommentTypeToAddForm('add', ${id});">댓글</li>
                        <li>
                            <img onclick="voteLikeInComment(${id}, 1)" id="comment-${id}-upvote" class="image-sm" alt="" src="{{ asset('image/upvote.png') }}" />
                        </li>
                        <li><span class="comment-like">${sumOfLikes}</li>
                        <li><img onclick="voteLikeInComment(${id}, -1)" id="comment-${id}-downvote" class="image-sm" alt="" src="{{ asset('image/upvote.png') }}" /></li>
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
    <input type="hidden" name="id" value="${commentID}">
    <div class="reply-input">
        <textarea
        name="content"
        id="reply_text"
        >${value}</textarea>

        <div class="form-btn">
            <div class="reset-btn">
                <button onclick="cancleForm('${form}', ${commentID})" type="reset">취소</button>
            </div>

            <div class="write-btn">
                <button type="submit" onclick="checkCommentTypeToProcess('${form}', ${commentID});">등록</button>
            </div>
        </div>
    </div>
</form>
</div>
</script>
@endsection
