@section('comment')
    <!-- 댓글 작성 폼 -->
    <div class="comment-write-form">
        <form method="POST" onSubmit="return false;" id="comment-form">
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <div class="form-title">
                <h5>댓글 쓰기</h5>
            </div>

            <div class="comment-input">
                <textarea name="content" id="comment_text"></textarea>
                <div class="form-btn d-flex justify-content-end">
                    {{--                <div class="reset-btn">--}}
                    {{--                    <button type="button" data-bs-dismiss="modal" aria-label="Close">취소</button>--}}
                    {{--                </div>--}}

                    <div class="write-btn">
                        <button type="submit" onclick="checkCommentTypeToProcess('add');">등록</button>
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

            <div class="comment-list">
            @forelse ($comments as $comment)
                <!-- 댓글 리스트 -->
                    <div style="padding-left:{{ ($comment->depth <= 4) ? $comment->depth*22 : 4*22 }}px;"
                         class="comment-item comment-{{ $comment->id }}">
                        <div class="comment-top">
                            <div class="write-info {{ $comment->depth>0 ? 'write-info-line':'' }}">
                                <img src="{{ $comment->user->avatar }}" class="mr-2" alt="닉네임"/>
                                <div class="d-flex justify-content-between comment-item-header-r">
                                    {{--                        inline-block --}}
                                    <div class="comment-modi-form">
                                        <span class="nickname">{{ $comment->user->name }}</span>
                                        <span class="sub_txt">{{ $comment->updated_at->diffForHumans() }}</span>
                                        @if(auth()->id()==$comment->user_id)
                                            <button class="sub_txt"
                                                    onclick="checkCommentTypeToAddForm('edit', {{ $comment->id }})">
                                                <div class="function-text">
                                                    <p>수정</p>
                                                </div>
                                            </button>
                                            <button class="sub_txt" onclick="deleteComment({{ $comment->id }})">
                                                <div class="function-text">
                                                    <p>삭제</p>
                                                </div>
                                            </button>
                                        @endif
                                    </div>
                                    {{--                            <div class="comment-info">--}}
                                    {{--                                <ul>--}}
                                    <div>
                                        @auth
                                            <button class="sub_txt" data-bs-type="comment"
                                                    data-bs-id="{{ $comment->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#openStampModal">스탬프
                                            </button>
                                        @endauth
                                        @guest
                                            <button class="sub_txt" onclick="notLogged();">스탬프</button>
                                        @endguest
                                        {{--                            <li></li>--}}
                                        @auth
                                            <button class="sub_txt"
                                                    onclick="checkCommentTypeToAddForm('add', {{ $comment->id }});">댓글
                                            </button>
                                        @endauth
                                        @guest
                                            <button class="sub_txt" onclick="notLogged();">댓글</button>
                                        @endguest
                                        <button>
                                            <img onclick="voteLikeInComment({{ $comment->id }}, 1)"
                                                 id="comment-{{ $comment->id }}-upvote" class="image-sm" alt=""
                                                 @if($comment->existCommentLike == 1)
                                                 src="{{ asset('image/upvote_c.png') }}"/>
                                            @else
                                                src="{{ asset('image/upvote.png') }}" />
                                            @endif
                                        </button>
                                        {{--                                    <li>--}}
                                        <button class="sub_txt comment-like">{{ $comment->likes->sum('like') }}</button>
                                        {{--                                    </li>--}}
                                        <button>
                                            <img onclick="voteLikeInComment({{ $comment->id }}, -1)"
                                                 id="comment-{{ $comment->id }}-downvote" class="image-sm" alt=""
                                                 @if($comment->existCommentLike == -1)
                                                 src="{{ asset('image/downvote_c.png') }}"/>
                                            @else
                                                src="{{ asset('image/downvote.png') }}" />
                                            @endif
                                        </button>
                                        {{--                                </div>--}}
                                        {{--                                </ul>--}}
                                    </div>
                                    {{--                            </div>--}}
                                </div>
                                <div class="stamps">
                                    @foreach($comment->stampsCount as $stamp)
{{--                                        @dd($stamp)--}}
                                        <div class="stamp-item comment-{{ $stamp->stamp_id }}-stamp
                                        @if($stamp->totalCount>1)
                                            multi-stamps">
                                            @else
                                                ">
                                            @endif
                                            <img src="/image/{{ $stamp->image }}" alt="">
                                            @if($stamp->totalCount>1)
                                                <span class="stamp_count">{{ $stamp->totalCount }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
{{--                                <div class="comment-cont">--}}
{{--                                    <p>--}}
{{--                                        {!! $comment->content !!}--}}
{{--                                    </p>--}}
{{--                                </div>--}}
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
            </div>
        </div>
    @endif


    <!-- 하단 기능 Comment -->
    <div class="board-bot-function d-none" id="post-bot-function">
        <div class="left-function">
            <div class="page-arrow mr-3">
                <img onclick="voteLikeInPost({{ $post->id }},1)" id="post-upvote-fix" class="image-m clickable"
                     alt="위로"
                     @if($post->existPostLike == 1)
                     src="{{ asset('image/upvote_c.png') }}"/>
                @else
                    src="{{ asset('image/upvote.png') }}" />
                @endif
                <span style="width: 20px; " class="text-center post-like">{{ $post->likes->sum('like') }}</span>
                <img onclick="voteLikeInPost({{ $post->id }},-1)" id="post-downvote-fix"
                     class="image-m clickable" alt="아래로"
                     @if($post->existPostLike == -1)
                     src="{{ asset('image/downvote_c.png') }}"/>
                @else
                    src="{{ asset('image/downvote.png') }}" />
                @endif
            </div>
            @auth
                <img data-bs-type="post" data-bs-id="{{ $post->id }}" data-bs-toggle="modal"
                     data-bs-target="#openStampModal" class="mr-3 stamp-image image-m clickable"
                     src="{{ asset('image/stamp_c.png') }}"/>
                {{--            <img alt="stamp" data-bs-type="post" data-bs-id="{{ $post->id }}" data-bs-toggle="modal" data-bs-target="#openStampModal1" class="mr-3 stamp-image image-m clickable" src="{{ asset('image/stamp_c.png') }}"/>--}}
            @endauth
            @guest
                <img alt="stamp" onclick="notLogged()" class="mr-3 stamp-image image-m clickable"
                     src="{{ asset('image/stamp_c.png') }}"/>
            @endguest
            <img src="{{ asset('image/share_c.png') }}" class="mr-3 clickable image-m" alt=""/>
            <img class="mr-3 favorit-image image-m clickable" id="post-scrap"
                 onclick="scrapPost({{ $post->id }})" alt="favorit" src="{{ asset('image/scrap_c.png') }}"/>
            <a href="javascript:$('#post').get(0).scrollIntoView( {behavior: 'smooth' })"><img
                    src="{{ asset('image/message.png') }}" alt="message" class="message-image"></a>
        </div>

        <div class="right-function">
            <a href="javascript:$('#open_post_modal').animate( { scrollTop : 0 }, 400 );"><img
                    src="{{ asset('image/message.png') }}" alt="message" class="message-image"></a>
            {{--        <a href="javascript:$('#open_post_modal').scrollTop(0);"><img src="{{ asset('image/message.png') }}" alt="message" class="message-image"></a>--}}
        </div>
    </div>

    <script>
        //# sourceURL=comment

        // add : 댓글, 대댓글   |   edit : 수정
        function checkCommentTypeToAddForm(commentType, commentID) {
            if (commentType == "edit") {
                checkExistEditForm(commentID);
            } else if (commentType == "add") {
                checkExistAddForm(commentID);
            }
        }

        function checkExistEditForm(commentID) {
            var el = $(".reply-form");

            if (el.length >= 1) {
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
            if (status === "show") {
                el.hide();

                // var value = escapeHTML($(`.comment-${commentID} .comment-cont p`).html());
                var templateValues = {
                    "commentID": commentID,
                    "value": "",
                    "form": "edit"
                };

                // $("#replyWriteForm").tmpl(templateValues).appendTo(`.comment-${commentID} .comment-item`);
                $("#replyWriteForm").tmpl(templateValues).appendTo(`.comment-${commentID}`);
            } else if (status === "hide") {
                $(`.comment-${commentID} .reply-form`).remove();
                el.show();
            }
        }

        function checkExistAddForm(commentID) {
            var el = $(".reply-form");

            if (el.length >= 1) {
                // 이미 열려있는 폼의 아이디를 가져온다
                var existCommentID = $(".reply-form input[name='id']").val();
                toggleAddForm('hide', existCommentID);

                // 새로 수정하고하는 댓글의 수정 폼을 연다
                // toggleAddForm('show', commentID);
            } else {
                toggleAddForm('show', commentID);
            }
        }

        function toggleAddForm(status, commentID) {
            if (status === "show") {
                var templateValues = {
                    "commentID": commentID,
                    "value": "",
                    "form": "add"
                };

                // $("#replyWriteForm").tmpl(templateValues).appendTo(`.comment-${commentID} .comment-item`);
                $("#replyWriteForm").tmpl(templateValues).appendTo(`.comment-${commentID}`);
            } else if (status === "hide") {
                $(`.comment-${commentID} .reply-form`).remove();
            }
        }

        function cancleForm(form, commentID) {
            if (form === "edit") {
                toggleEditForm("hide", commentID);
            } else if (form === "add") {
                toggleAddForm("hide", commentID);
            }
        }

        function checkCommentTypeToProcess(form, commentID) {
            // make it one
            if (form === "add") {
                addComment(form, commentID);
            } else if (form === "edit") {
                addComment(form, commentID);
            }
        }

        function addComment(form, commentID) {
            // init variables
            var data = "";
            var type = "";
            var url = "";

            // 댓글, 대댓글 구분
            if (commentID) {
                data = $(`#open_post_modal .comment-${commentID} .reply-form form`).serialize();
            } else {
                data = $("#open_post_modal #comment-form").serialize();
            }

            // 생성, 수정 구분
            if (form === "add") {
                type = "post";
                url = "/comment";
            } else if (form === "edit") {
                type = "put";
                url = "/comment/" + commentID;
            }
            delay(function () {
                $.ajax({
                    url: url,
                    data: data,
                    type: type,
                    success: function (data) {
                        if (form === "edit") { // 기존 댓글 업데이트 로직
                            $(`.comment-${commentID} .comment-cont p`).html(data.content);
                            toggleEditForm('hide', commentID);
                        } else if (form === "add") { // 신규 댓글 생성 로직
                            var templateValues = {
                                "id": data.id,
                                "depth": (data.depth <= 4) ? data.depth * 22 : 4 * 22,
                                "updated_at_modi": data.updated_at_modi,
                                "group": data.group,
                                "content": data.content,
                                "sumOfLikes": data.sumOfLikes,
                                "post_id": data.post_id,
                                "avatar": data.user.avatar,
                                "commentCount": data.commentCount,
                                "name": data.user.name
                            };

                            if (data.commentCount < 2) { // 첫번째 글일 때, 댓글보기 헤더 추가
                                $("#replyForm").tmpl(templateValues).insertAfter('.comment-write-form');
                            } else { // 첫번쨰 글이 아닌 경우 그냥 추가
                                if (commentID) { // 대댓글
                                    $("#replyForm").tmpl(templateValues).insertAfter(`.comment-${commentID}`);
                                } else { // 댓글
                                    $("#replyForm").tmpl(templateValues).insertAfter(".section-title");
                                }
                            }
                            if (commentID) {
                                cancleForm('add', commentID);
                            } else {
                                $("#comment-form #comment_text").val('');
                            }
                            // main page section modify
                            // $(`#post-${data.post_id} .commentCount, #open_post_modal .commentCount`).text(data.commentCount);
                            var mainCommentValue = $(`#post-${data.post_id} .commentCount`).eq(0).text();
                            if (mainCommentValue > 1) {
                                $(`#post-${data.post_id} .commentCount`).text(parseInt(mainCommentValue) + 1);
                            } else if (mainCommentValue === '') {
                                var afterData = '<span class="titleSub">[&nbsp;<span class="commentCount">1</span>&nbsp;]</span>';
                                $(`#post-${data.post_id} .title a p`).after(afterData);
                            }


                            // post title section modify
                            var commentValue = $("#open_post_modal .commentCount").eq(0).text();
                            if (commentValue > 1) {
                                $(".commentCount").eq(0).text(parseInt(commentValue) + 1);
                            } else if (commentValue === '') {
                                var afterData = '<span class="titleSub">[&nbsp;<span class="commentCount">1</span>&nbsp;]</span>';
                                $(".modal-parent > .modal-wrap > .modal-header > .modal-title h4 p").after(afterData);
                            }
                        }


                    },
                    error: function (err) {
                        if (err.status === 401) {
                            alert("로그인이 필요한 기능입니다.");
                        } else {
                            alert("댓글이 저장되지않았습니다\n관리자에게 문의해주세요.");
                        }
                    }
                })
            }, 300);
        }

        function deleteComment(id) {
            if (confirm('삭제하시겠습니까 ?')) {
                $.ajax({
                    type: "DELETE",
                    url: "/comment/" + id,
                    data: {"id": id},
                    success: function (data) {
                        var el = '.comment-' + id;
                        $(el).remove();
                        var commentTotalCount = $(".comment-list").length;
                        if (commentTotalCount === 0) {
                            $("#comment").remove();
                        }

                        // post title section modify
                        var commentCount = $(".commentCount").eq(0).text();
                        if (commentCount > 1) {
                            $(".commentCount").eq(0).text(parseInt(commentCount) - 1);
                        } else {
                            var titleSub = $(".titleSub").eq(0).remove();
                        }

                        // main page title section modify
                        var getPostID = $("input[name='post_id']").val();
                        var mainCommentValue = $(`#post-${getPostID} .commentCount`).eq(0).text();
                        if (mainCommentValue > 1) {
                            $(`#post-${getPostID} .commentCount`).text(parseInt(mainCommentValue) - 1);
                        } else if (mainCommentValue == 1) {
                            $(`#post-${getPostID} .title a .titleSub`).remove();
                        }

                        // blah blah
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
            }
            return false;
        }

        function voteLikeInComment(id, like, obj) {
            $.ajax({
                url: "/comment/" + id + "/like",
                data: {like: like},
                type: "post",
                success: function (data) {
                    var el = ".comment-" + id + " .comment-like";
                    commentClearLike(id);
                    commentSelectLike(id, data.like);
                    $(el).text(data.totalLike);
                    // alert("처리되었습니다.");
                },
                error: function (err) {
                    if (err.status === 401) {
                        alert("로그인이 필요한 기능입니다");
                    } else {
                        alert("문제가 생겨 확인 중입니다")
                    }
                }
            });
        }

        function commentClearLike(id) {
            $(`#comment-${id}-downvote`).attr("src", "{{ asset('image/downvote.png') }}");
            $(`#comment-${id}-upvote`).attr("src", "{{ asset('image/upvote.png') }}");
        }

        function commentSelectLike(id, like) {
            if (like === 1) {
                $("#comment-" + id + "-upvote").attr("src", "{{ asset('image/upvote_c.png') }}");
            } else if (like === -1) {
                $("#comment-" + id + "-downvote").attr("src", "{{ asset('image/downvote_c.png') }}");
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
                    <img src="${avatar}" class="mr-2" alt="닉네임" />
                    <div class="d-flex justify-content-between comment-item-header-r">
                        <div class="comment-modi-form">
                            <span class="nickname">${name}</span>
                            <span class="sub_txt">${updated_at_modi}</span>
                            <button class="sub_txt" onclick="checkCommentTypeToAddForm('edit', ${id})">
                                <div class="function-text">
                                    <p>수정</p>
                                </div>
                            </button>
                            <button class="sub_txt" onclick="deleteComment(${id})">
                                <div class="function-text">
                                    <p>삭제</p>
                                </div>
                            </button>
                        </div>
                        <div>
                            <button class="sub_txt">스탬프</button>
                            <button class="sub_txt" onclick="checkCommentTypeToAddForm('add', ${id});">댓글</button>
                            <button class="sub_txt">
                                <img onclick="voteLikeInComment(${id}, 1)" id="comment-${id}-upvote" class="image-sm" alt="" src="{{ asset('image/upvote.png') }}" />
                            </button>
                            <button class="sub_txt"><span class="comment-like">${sumOfLikes}</button>
                            <button class="sub_txt"><img onclick="voteLikeInComment(${id}, -1)" id="comment-${id}-downvote" class="image-sm" alt="" src="{{ asset('image/upvote.png') }}" /></button>
                        </div>
                    </div>
                    <div class="stamps">
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
</div>
@{{/if}}


    </script>
    <script id="replyWriteForm" type="text/x-jquery-tmpl">
<div class="reply-form mb-3">
    <form method="post" onSubmit="return false;" id="comment-form-${commentID}">
    <input type="hidden" name="id" value="${commentID}">
    <div class="reply-input">
        <textarea
        name="content"
        id="reply_text"
        >${value}</textarea>

        <div class="form-btn d-flex justify-content-end mt-2">
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
