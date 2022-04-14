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

            @foreach ($comments as $comment)
                <div class="comment-list comment-{{ $comment->id }}">
                    <div style="padding-left:{{ ($comment->depth > 0) ? 22 : 0 }}px;"
                         class="comment-item">
                        <div class="comment-top">
                            <div class="write-info {{ $comment->depth>0 ? 'write-info-line':'' }}">
                                <div class="comment-item-header-r">
                                    <div class="comment-modi-form float-left">
                                        <img src="{{ $comment->user->avatar }}" width="20" alt="닉네임"/>
                                        <span class="nickname">{{ $comment->user->name }}</span>
                                        <span class="sub_txt">{{ $comment->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="comment-modi-form-r float-right">
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
                                        <button style="color: rgb(120,120,120);" class="comment-like">{{ $comment->likes->sum('like') }}</button>
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
                                    </div>
                                </div>
                                <div class="stamps">
                                    @foreach($comment->stampsCount as $stamp)
                                        {{--                                        @dd($stamp)--}}
                                        <div class="stamp-item comment-{{ $stamp->stamp_id }}-stamp multi-stamps">
                                            <img src="/image/{{ $stamp->image }}" alt="">
                                            <span class="stamp_count">{{ $stamp->totalCount }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="comment-cont">
                                @if($comment->targetUser)
                                    <span class="sub_text">To. {{ $comment->targetUser->name }}</span>
                                @endif
                                <p>
                                    {!! $comment->content !!}
                                </p>
                            </div>
                            <div class="comment-own float-left">
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
                        </div>
                    </div>
                </div>
                <hr class="cst_hr">
            @endforeach
        </div>
    @endif
        <!-- 하단 기능 Comment -->
            {{--        <div class="flex-container board-bot-function justify-content-between" style="position: sticky; top:0px;  background: rgba(252, 252, 252, 1) !important;" id="post-bot-function">--}}
    <div class="d-none flex-container flex-justify-space-between" id="post-bot-function">
        <div class="left-function flex-container">
            {{--                <div class="page-arrow">--}}
            <img onclick="@if(auth()->check()) voteLikeInPost({{ $post->id }},1) @else notLogged(); @endif"
                 id="post-upvote-fix" class="image-sm clickable m-0" alt="위로"
                 @if($post->existPostLike == 1)
                 src="{{ asset('image/upvote_c.png') }}"/>
            @else
                src="{{ asset('image/upvote.png') }}" />
            @endif
            <span class="post-like">{{ $post->likes->sum('like') }}</span>
            <img onclick="@if(auth()->check()) voteLikeInPost({{ $post->id }},-1) @else notLogged(); @endif"
                 id="post-downvote-fix" class="image-sm clickable" alt="아래로"
                 @if($post->existPostLike == -1)
                 src="{{ asset('image/downvote_c.png') }}"/>
            @else
                src="{{ asset('image/downvote.png') }}" />
            @endif

            <img alt="stamp" class="stamp-image image-sm clickable" src="{{ asset('image/stamp.png') }}"/>
            <img class="favorit-image image-sm clickable" id="post-scrap"
                 onclick="@if(auth()->check()) scrapPost({{ $post->id }}) @else notLogged(); @endif"
                 alt="favorit"
                 @if($post->postScrap == 1)
                 src="{{ asset('image/scrap_c.png') }}"/>
            @else
                src="{{ asset('image/scrap.png') }}" />
            @endif
            <a href="javascript:$('#post').get(0).scrollIntoView( {behavior: 'smooth' })"><img
                    src="{{ asset('image/message.png') }}" alt="message" class="message-image"></a>
            {{--                </div>--}}
        </div>

        <div class="right-function">
            <a href="javascript:$('#open_post_modal').animate( { scrollTop : 0 }, 0 );">맨 위로</a>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            window.addEventListener('resize', () => {
                // set Comment Max-Height
                setModalContentHeight();
            });
        });

        function setModalContentHeight() {
            // $("#post-bot-function").offset().top - $("#open_post_modal").offset().top;
            // $("#post-bot-function").offset()
        }
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
            var validate = '';

            // 댓글, 대댓글 구분
            if (commentID) {
                // data = $(`.comment-${commentID} .reply-form form`).serialize();
                validate = $(`#open_post_modal .comment-${commentID} .reply-form form #reply_text`).val();
                data = $(`#open_post_modal .comment-${commentID} .reply-form form`).serialize();
            } else {
                // data = $("#comment-form").serialize();
                validate = $("#open_post_modal #comment-form #comment_text").val();
                data = $("#open_post_modal #comment-form").serialize();
            }
            if(validate === "") {
                alert("내용을 입력해주세요 ");
                return false;
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
                        // data.content = htmlentities($data, ENT_QUOTES, 'UTF-8');
                        if (form === "edit") { // 기존 댓글 업데이트 로직
                            $(`.comment-${commentID} .comment-cont p`).html(data.content);
                            toggleEditForm('hide', commentID);
                        } else if (form === "add") { // 신규 댓글 생성 로직
                            var templateValues = {
                                "id": data.id,
                                "depth": (data.depth > 0) ? 22 : 0,
                                "updated_at_modi": data.updated_at_modi,
                                "group": data.group,
                                "content": data.content,
                                "sumOfLikes": data.sumOfLikes,
                                "postID": data.postID,
                                "avatar": data.user.avatar,
                                "commentCount": data.commentCount,
                                "name": data.user.name,
                            };

                            if (data.commentCount < 2) { // 첫번째 글일 때, 댓글보기 헤더 추가
                                $("#replyForm").tmpl(templateValues).insertAfter('.comment-write-form');
                            } else { // 첫번쨰 글이 아닌 경우 그냥 추가
                                if (commentID) { // 대댓글
                                    templateValues.target_name = "<span class='sub_text'>To. "+data.target_name+"</span>";
                                    $("#replyForm").tmpl(templateValues).insertAfter( $(`.comment-${commentID}`).next() );
                                } else { // 댓글
                                    $("#replyForm").tmpl(templateValues).insertAfter(".section-title");
                                }
                            }
                            $(`#post-${data.postID} .commentCount, #open_post_modal .commentCount`).text(data.commentCount);
                            if (commentID) {
                                cancleForm('add', commentID);
                            } else {
                                $("#comment-form #comment_text").val('');
                            }

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
                        var commentTotalCount = $(".comment-item").length;
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
    @{{else}}
    <hr class="cst_hr">
    @{{/if}}
   <div class="comment-list comment-${id}">
        <div style="padding-left:${depth}px;">
            <div class="comment-item">
                <div class="comment-top">
                    <div style="" class="write-info">
                        <div class="comment-item-header-r">
                            <div class="comment-modi-form float-left">
                                <img src="${avatar}" width="20" alt="닉네임" />
                                <span class="nickname">${name}</span>
                                <span class="sub_txt">${updated_at_modi}</span>
                            </div>
                            <div class="comment-modi-form-r float-right">
                                <button class="sub_txt" data-bs-type="comment"
                                    data-bs-id="${id}" data-bs-toggle="modal"
                                    data-bs-target="#openStampModal">스탬프
                                </button>
                                <button class="sub_txt" onclick="checkCommentTypeToAddForm('add', ${id});">댓글</button>
                                <button>
                                    <img onclick="voteLikeInComment(${id}, 1)" id="comment-${id}-upvote" class="image-sm" alt="" src="{{ asset('image/upvote.png') }}" />
                                </button>
                                <button class="sub_txt"><span class="comment-like">${sumOfLikes}</button>
                                <button><img onclick="voteLikeInComment(${id}, -1)" id="comment-${id}-downvote" class="image-sm" alt="" src="{{ asset('image/upvote.png') }}" /></button>
                            </div>
                        </div>
                        <div class="stamps"></div>
                        <div class="comment-cont">
                            @{{if target_name}}
                                <span class="sub_text">${target_name}</span>
                            @{{/if}}
                            <p>
                                ${content}
                            </p>
                        </div>
                        <div class="comment-own float-left">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    @{{if commentCount < 2}}
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

        <div class="form-btn d-flex mt-1 mb10 justify-content-end">
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

