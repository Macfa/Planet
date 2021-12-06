
    <div class="modal-parent container-fluid flex-grow-1">
        <div class="modal-wrap">
            <div class="modal-header flex-wrap-wrap">
                <div class="modal-title flex-0-0-100">
                    <h4>
                        <p>{{ $post->title }}&nbsp;&nbsp;</p>
                        @if($post->comments->count() > 0)
                            <span class="titleSub">[&nbsp;<span class="commentCount">{{ $post->comments->count() }}</span>&nbsp;]</span>
                        @endif
                        <span class="stamps">
                            @foreach($post->stampInPosts as $stampInPost)
                                <span class="stamp-{{ $stampInPost->stamp_id }}">
                                    <img style="width:31px;" src="{{ $stampInPost->stamp->image }}" alt="">
                                    <span>
                                        @if($stampInPost->count > 1)
                                                {{ $stampInPost->count }}
                                        @endif
                                    </span>
                                </span>
                            @endforeach
                            </span>
                    </h4>
                </div>
                <div class="write-info">
{{--                    <p><span><a href="{{ route('channel.show', $post->channel_id) }}">[{{ $post->channel->name }}]</a></span>&nbsp;온 <a href="{{ route('user.show', 'post') }}">{{ $post->user->name }}</a> / {{ $post->created_at->diffForHumans() }}</p>--}}
                    <p class="sub_text"><span><a href="{{ route('channel.show', $post->channel_id) }}">[&nbsp;{{ $post->channel->name }}&nbsp;]&nbsp;</a></span> {{ $post->created_at->diffForHumans() }} / <a href="{{ route('user.show', ["user" => $post->user] ) }}">{{ $post->user->name }}</a></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
{{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-image: url({{ asset('image/close.png') }})"></button>--}}
            </div>

            <div class="modal-body" style="flex: 0 0 auto; height: calc(100vh - 140.6px)">
                <!-- 왼쪽 게시글 내용 -->
                <div class="modal-left">
                    <div class="modal-content">
                        <div class="board-text">
                            {!! $post->content !!}
                        </div>

                        <div class="board-etc-function">
                            <!-- 게시글 기타 기능 -->
                            @if(auth()->id()==$post->user_id)
                                <div class="ml-a items-r justify-content-end">
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
                        </div>

                        <div class="board-etc-function" id="post">
                            <ul>
                                <li class="clickable items">
                                    <img id="post-upvote" onclick="voteLikeInPost({{ $post->id }},1);" class="image-sm" alt=""
{{--                                    <img id="post-upvote" onclick="voteLikeInPost({{ $post->id }},1)" class="image-sm" alt=""--}}
                                         @if($post->existPostLike == 1)
                                             src="{{ asset('image/upvote_c.png') }}" />
                                        @else
                                            src="{{ asset('image/upvote.png') }}" />
                                        @endif
                                </li>
                                <li class="items justify-content-center">
                                    <div class="post-like">
                                        <p>{{ $post->likes->sum('like') }}</p>
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
                                <!-- Button trigger modal -->
                                @auth
                                    <li data-bs-type="post" data-bs-id="{{ $post->id }}" data-bs-toggle="modal" data-bs-target="#openStampModal" class="clickable items">
{{--                                    <li class="items"><a data-bs-toggle="modal" href="#openStampModal">--}}
                                @endauth
                                @guest
                                    <li class="items clickable" onclick="notLogged();">
                                @endguest
                                    <img src="{{ asset('image/stamp_c.png') }}" class="image-sm" alt="" />

                                    <div class="function-text">
                                        <p>스탬프</p>
                                    </div>
                                </li>
                                @auth
                                    <li class="clickable items">
                                @endauth
                                @guest
                                    <li onclick="notLogged()" class="clickable items">
                                @endguest
                                    <img src="{{ asset('image/share_c.png') }}" class="image-sm" alt="" />

                                    <div class="function-text">
                                        <p>공유</p>
                                    </div>
                                </li>
                                <li class="clickable items" onclick="scrapPost({{ $post->id }});">
                                    <img class="image-sm" name="scrap" alt="" src="{{ asset('image/scrap_c.png') }}" />
{{--                                         @if($post->existPostScrap == 1)--}}
{{--                                             src="{{ asset('image/scrap_c.png') }}" />--}}
{{--                                        @else--}}
{{--                                             src="{{ asset('image/scrap.png') }}" />--}}
{{--                                        @endif--}}

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
                            </ul>
                        </div>
                    @yield('comment')
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="openStampModal" tabindex="-1" aria-labelledby="openStamp" aria-hidden="true" role="dialog">
                <div class="modal-dialog" style="margin-top:250px; max-width: 80%; width: 700px;">
                    <div class="modal-content"></div>
                </div>
            </div>
            {{--    <script src="{{ asset('js/editorShow.js') }}"></script>--}}
            <script>
                $("#open_post_modal").scroll(function() {
                    var headerHeight = $("#header").height();
                    var postOffsetTop = $("#post").offset().top;

                    // console.log(headerHeight);
                    // console.log(postOffsetTop);
                    if(postOffsetTop - headerHeight <= 0 ) {
                        var checkExist = $("#post-bot-function").hasClass("sticky-bottom");
                        if(checkExist === false) {
                            $("#post-bot-function").addClass("sticky-bottom");
                            $("#post-bot-function").removeClass("d-none");
                        }
                    } else {
                        var checkExist = $("#post-bot-function").hasClass("sticky-bottom");
                        if(checkExist === true) {
                            $("#post-bot-function").removeClass("sticky-bottom");
                            $("#post-bot-function").addClass("d-none");
                        }
                    }
                });
                $(document).ready(function () {
                // $(document).load(function () {
                    //adjust modal body sizes
                    var fit_modal_body;

                    fit_modal_body = function(modal) {
                        console.log(modal);
                        var body, bodypaddings, header, headerheight, height, modalheight;
                        header = $(".modal-header", modal).eq(0);
                        // header = $(".modal-header", modal).eq(0);
                        // footer = $(".modal-footer", modal);
                        body = $(".modal-body", modal).eq(0);
                        modalheight = parseInt(modal.css("height"));
                        headerheight = parseInt(header.css("height")) + parseInt(header.css("padding-top")) + parseInt(header.css("padding-bottom"));
                        // footerheight = parseInt(footer.css("height")) + parseInt(footer.css("padding-top")) + parseInt(footer.css("padding-bottom"));
                        // bodypaddings = parseInt(body.css("padding-top")) + parseInt(body.css("padding-bottom"));
                        bodypaddings = parseInt(header.css("height")) + parseInt(body.css("padding-top")) + parseInt(body.css("padding-bottom"));
                        // height = $(window).height() - headerheight - footerheight - bodypaddings - 150;
                        // height = $(window).height() - headerheight - bodypaddings - 150;
                        height = headerheight + bodypaddings;
                        console.log(body, height);
                        body.css({'background-color': 'red'});
                        return body.css({"height": "" + height + "px"});
                    };

                    fit_modal_body($("#open_post_modal"));
                    $(window).resize(function() {
                        return fit_modal_body($("#open_post_modal"));
                    });

                    document.querySelectorAll( 'oembed[url]' ).forEach( element => {
                        // Create the <a href="..." class="embedly-card"></a> element that Embedly uses
                        // to discover the media.
                        const anchor = document.createElement( 'a' );

                        anchor.setAttribute( 'href', element.getAttribute( 'url' ) );
                        anchor.className = 'embedly-card';

                        element.appendChild( anchor );
                    } );
                });
                $("#openStampModal").on('hide.bs.modal', function(event) {
                    event.stopPropagation();
                });
                $("#openStampModal").on('show.bs.modal', function(event) {
                    event.stopPropagation();
                    console.log(event);
                    console.log(event.target.id);
                    if (event.target.id === 'openStampModal') {
                        var modalBody = $("#openStampModal .modal-content");
                        var button = event.relatedTarget;
                        var id = button.getAttribute('data-bs-id');
                        var type = button.getAttribute('data-bs-type');

                        $.ajax({
                            url: '/stamp',
                            type: 'get',
                            success: function(data) {
                                modalBody.html(data);
                                $("#openStampModal").on('shown.bs.modal', function(event) {
                                    // event.stopPropagation();
                                    $("#category-data .stamp-list:first button").click();
                                    $("#openStampModal input[name=type]").val(type);
                                    $("#openStampModal input[name=id]").val(id);
                                });
                            },
                            error: function(err) {
                                console.log(err);
                            }
                        })
                    }
                })

                // var openStampModal = document.getElementById('openStampModal')
                // openStampModal.addEventListener('show.bs.modal', function (event) {
                //     alert(1);
                // });
                // $.fn.modal.defaults.maxHeight = function(){
                    // subtract the height of the modal header and footer
                    // return $(window).height() - 165;
                // }
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
                function voteLikeInPost(id, like) {
                    $.ajax({
                        url: "/post/"+id+"/like",
                        data: { like:like },
                        type: "post",
                        success: function(data) {
                            // console.log(data);
                            clearLike(id);
                            selectLike(data.like, id, data.totalLike);
                            $(".post-like").text(data.totalLike);
                            $(`#post-${id} .post-like-main`).text(data.totalLike);
                        },
                        error: function(err) {
                            if(err.status === 401) {
                                alert(err.responseText);
                            } else {
                                alert("문제가 생겨 확인 중입니다")
                            }
                        }
                    });
                }
                function clearLike(id) {
                    $("#post-downvote, #post-downvote-fix").attr("src", "{{ asset('image/downvote.png') }}");
                    $("#post-upvote, #post-upvote-fix").attr("src", "{{ asset('image/upvote.png') }}");
                    $(`#post-${id} .post-like-main`).attr('class', 'post-like-main updown dash');
                }
                function selectLike(like, id, totalLike) {
                    if(like == 1) {
                        $("#post-upvote, #post-upvote-fix").attr("src", "{{ asset('image/upvote_c.png') }}");
                    } else if(like == -1) {
                        $("#post-downvote, #post-downvote-fix").attr("src", "{{ asset('image/downvote_c.png') }}");
                    }

                    if(like != 0) {
                        if(totalLike > 0) {
                            $(`#post-${id} .post-like-main`).attr('class', 'post-like-main updown up');
                        } else if(totalLike < 0) {
                            $(`#post-${id} .post-like-main`).attr('class', 'post-like-main updown down');
                        }
                    }
                }
                function reportPost(postID) {
                    $.ajax({
                        url: "/post/"+postID+"/report",
                        type: "post",
                        success: function(data) {
                            alert(data.responseText);
                        },
                        error: function(err) {
                            if(err.status == 401) {
                                alert(err.responseText);
                            } else {
                                alert("문제가 생겨 확인 중입니다")
                            }
                        }
                    });
                }
                function scrapPost(postID) {
                    if(confirm('스크랩하시겠습니까?\n기존에 스크랩을 했었다면 스크랩이 삭제됩니다')) {
                        $.ajax({
                            url: "/post/"+postID+"/scrap",
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
                            error: function(err) {
                                if(err.status == 401) {
                                    alert(err.responseText);
                                } else {
                                    alert("문제가 생겨 확인 중입니다")
                                }
                            }
                        });
                    }
                }
                // function selectCategory(categoryID) {
                //     // alert(categoryID);
                //     $.ajax({
                //         url: "/stamp",
                //         data: { categoryID: categoryID },
                //         type: "get",
                //         success: function(data) {
                //             var result = {
                //                 'groups': data
                //             };
                //             $("#openStampModal #category-data > div").remove();
                //             $("#stampDataTemplate").tmpl(result).appendTo("#openStampModal #category-data");
                //         },
                //         errror: function(err) {
                //             alert("기능에러로 스탬프를 불러오지 못 했습니다.");
                //         }
                //     });
                // }
            </script>
        </div>
    </div>
    <script id="stampDataTemplate" type="text/x-jquery-tmpl">
    @{{each groups}}
{{--    <p>${name}</p>--}}
        <div>
            <div>
                <span id="group-name">${name}</span>
            </div>
            @{{each stamps}}
                <div>
                    <ul class="flex-container">
                        <li class="col">
                            <button onclick="purchaseStamp(${id}, {{ $post->id }});">
                                <img src="${image}" />
                                <span>${coin}</span>
                            </button>
                        </li>
                    </ul>
                </div>
            @{{/each}}
        </div>
    @{{/each}}
</script>

