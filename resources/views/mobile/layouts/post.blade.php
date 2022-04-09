
    <div class="modal-parent wid100" style="background-color: #888888;">
        <div class="modal-wrap" style="background-color: #ffffff;">
            <div class="modal-header flex-wrap-wrap">
                <div class="modal-title flex-0-0-100">
                    <h4>
                        <p>{{ $post->title }}&nbsp;&nbsp;</p>
                        @if($post->comments->count() > 0)
                            <span class="titleSub">[&nbsp;<span class="commentCount">{{ $post->comments->count() }}</span>&nbsp;]</span>
                        @endif
                    </h4>
                </div>
                <div class="stamps post-{{ $post->id }}-stamps flex-0-0-100">
                    @foreach($post->stampsCount as $stamp)
                        <div class="stamp-item stamp-{{ $stamp->stamp_id }} multi-stamps">
                            <img src="{{ url($stamp->image) }}" alt="" />
                            <span class="stamp_count">{{ $stamp->totalCount }}</span>
                        </div>
                    @endforeach
                            </div>
                <div class="write-info">
                    <p class="sub_text"><span><a href="{{ route('channel.show', $post->channel_id) }}">[&nbsp;{{ $post->channel->name }}&nbsp;]&nbsp;</a></span> {{ $post->created_at->diffForHumans() }} / <a href="{{ route('user.show', ["user" => $post->user] ) }}">{{ $post->user->name }}</a></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
{{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-image: url({{ asset('image/close.png') }})"></button>--}}
            </div>

            <div class="modal-body" style="min-height: calc(100vh - 143px); padding-bottom: 50px;">
                <!-- 왼쪽 게시글 내용 -->
                <div class="modal-left">
                    <div>
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

                        <!-- 게시글 기타 기능 -->
                        <div class="board-etc-function" id="post">
                            <ul>
                                <li class="clickable items mr-0">
                                    <img id="post-upvote" onclick="@if(auth()->check()) voteLikeInPost({{ $post->id }},1) @else notLogged(); @endif" class="image-sm" alt=""
                                         @if($post->existPostLike == 1)
                                             src="{{ asset('image/upvote_c.png') }}" />
                                        @else
                                            src="{{ asset('image/upvote.png') }}" />
                                        @endif
                                </li>
                                <li style="flex: 0 0 5px;" class="items">
                                    <div class="post-like">
                                        <p>{{ $post->likes->sum('like') }}</p>
                                    </div>
                                </li>
                                <li class="clickable items">
                                    <img id="post-downvote" onclick="@if(auth()->check()) voteLikeInPost({{ $post->id }}, -1) @else notLogged(); @endif" class="image-sm" alt=""
                                         @if($post->existPostLike == -1)
                                            src="{{ asset('image/downvote_c.png') }}" />
                                        @else
                                            src="{{ asset('image/downvote.png') }}" />
                                        @endif
                                </li>
                                <!-- Button trigger modal -->
                                @auth
                                    <li data-bs-toggle="modal" data-bs-target="#openStampModal" data-bs-type="post" data-bs-id="{{ $post->id }}" class="clickable items">
                                @endauth
                                @guest
                                    <li onclick="notLogged()" class="clickable items">
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
                                <li class="clickable items" onclick="@if(auth()->check()) scrapPost({{ $post->id }}) @else notLogged(); @endif">
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
                                <li class="clickable items" onclick="@if(auth()->check()) reportPost({{ $post->id }}) @else notLogged(); @endif">
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
            <div class="modal fade" id="openStampModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%);">
                <div class="modal-dialog" style="margin-top:250px;">
                    <div class="modal-content">
                    </div>
                </div>
            </div>
            {{--    <script src="{{ asset('js/editorShow.js') }}"></script>--}}
            <script>

                $("#open_post_modal").scroll(function() {
                    var headerHeight = $("#header").height();
                    var postOffsetTop = $("#post").offset().top;

                    if(postOffsetTop - headerHeight <= 0 ) {
                        let checkCssExist = $("#open_post_modal").css("max-height");

                        var checkExist = $("#post-bot-function").hasClass("cst-fixed-bot");
                        // console.log(checkExist);
                        if(checkExist === false) {
                            $("#post-bot-function").addClass("cst-fixed-bot");
                            $("#post-bot-function").removeClass("d-none");
                            $("#comment:last-child").css("margin-bottom", "27px");
                            // console.log($("#post-bot-function").className);
                        }
                        if (checkCssExist === 'none') {
                            // let maxHeight = $("#post-bot-function").offset().top - $("#open_post_modal").offset().top;
                            // $("#open_post_modal").css("max-height", maxHeight);
                        }
                    } else {
                        var checkExist = $("#post-bot-function").hasClass("cst-fixed-bot");
                        let checkCssExist = $("#open_post_modal").css("max-height");

                        if(checkExist === true) {
                            $("#post-bot-function").removeClass("cst-fixed-bot");
                            $("#post-bot-function").addClass("d-none");
                        }
                        if (checkCssExist !== 'none') {
                            // 모달 콘텐츠의 높이 제한 걸기 -> 아래 고정이 제외되면 빈 공간이 생김
                            // var modalContentMaxHeight = $("body").height() - $("#header").outerHeight();
                            // $("#open_post_modal").css("max-height", modalContentMaxHeight);
                            $("#open_post_modal").css("max-height", 'none');
                        }
                    }
                });

                document.querySelectorAll( 'oembed[url]' ).forEach( element => {
                    // Create the <a href="..." class="embedly-card"></a> element that Embedly uses
                    // to discover the media.
                    const anchor = document.createElement( 'a' );

                    anchor.setAttribute( 'href', element.getAttribute( 'url' ) );
                    anchor.className = 'embedly-card';

                    element.appendChild( anchor );
                } );

                // var openStampModal = document.getElementById('openStampModal')
                // openStampModal.addEventListener('show.bs.modal', function (event) {
                //     alert(1);
                // });

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
                            clearLike();
                            selectLike(data.like);
                            $(".post-like").text(data.totalLike);
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
                function clearLike() {
                    $("#post-downvote, #post-downvote-fix").attr("src", "{{ asset('image/downvote.png') }}");
                    $("#post-upvote, #post-upvote-fix").attr("src", "{{ asset('image/upvote.png') }}");
                }
                function selectLike(like) {
                    if(like == 1) {
                        $("#post-upvote, #post-upvote-fix").attr("src", "{{ asset('image/upvote_c.png') }}");
                    } else if(like == -1) {
                        $("#post-downvote, #post-downvote-fix").attr("src", "{{ asset('image/downvote_c.png') }}");
                    }
                }
                function reportPost(postID) {
                    $.ajax({
                        url: "/post/"+postID+"/report",
                        type: "post",
                        success: function(data) {
                            alert(data);
                        },
                        error: function(err) {
                            if(err.status === 401) {
                                alert(err);
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
                            errror: function(err) {
                                if(err.status == 401) {
                                    alert(err.responseText);
                                } else {
                                    alert("문제가 생겨 확인 중입니다")
                                }
                            }
                        });
                    }
                }
                function selectCategory(id) {
                    $.ajax({
                        url: "/category/",
                        data: {
                            categoryId: id
                        },
                        type: "get",
                        success: function (data) {
                            console.log(data.length);
                            // console.log(data);
                            // console.log(id);
                            var replaceData = [];
                            for(var i=0; i<data.length; i++) {
                                replaceData.push({
                                    'stampId': data[i].id,
                                    'stampImage': '/image/'+data[i].image,
                                    'stampCoin': data[i].coin,
                                })
                            }
                            $(".category-data-list ul.d-flex li").remove();
                            $("#stampListTemplate").tmpl(replaceData).appendTo(".category-data-list ul.d-flex");
                        },
                        errror: function (err) {
                            alert("관리자에게 문의해주세요");
                        }
                    });
                }
                function selectStamp(id) {
                    $.ajax({
                        url: "/stamp/"+id,
                        data: {
                            stampID: id
                        },
                        type: "get",
                        success: function (data) {
                            // console.log(data);
                            var replaceData = {
                                'id': data.id,
                                'coin': data.coin,
                                'name': data.name,
                                'image': '/image/'+data.image,
                                'description': data.description,
                                'hasCoin': data.hasCoin,
                                'afterPurchaseCoin': data.afterPurchaseCoin
                            };
                            $("#openStampModal #selectStampItem .category-data-item").remove();
                            $("#selectStampTemplate").tmpl(replaceData).prependTo("#openStampModal #selectStampItem");
                        },
                        errror: function (err) {
                            alert("관리자에게 문의해주세요");
                        }
                    });
                }
                function purchaseStamp(stampID) {
                    var type = $("#openStampModal input[name=type]").val();
                    var id = $("#openStampModal input[name=id]").val();

                    // var url = '';
                    // if(type === "post") {
                    // }

                    if(confirm('구매하시겠습니까 ?')) {
                        $.ajax({
                            url: "/stamp/purchase",
                            data: {
                                stampID: stampID,
                                type: type,
                                id: id
                            },
                            type: "post",
                            success: function (data) {
                                $("#total_coin").text(data.currentCoin);
                                $("#openStampModal").modal("hide");
                                if(data.target === "post") {
                                    if(data.count === 1) {
                                        $(`.stamps.post-${id}-stamps`).append(`<div class="stamp-item stamp-${stampID} multi-stamps"><img alt='${data.name}' src='${data.image}' ><span class="stamp_count">${data.count}</span></div>`);
                                    } else if(data.count > 1) {
                                        if($(`.stamps.post-${id}-stamps div.stamp-${stampID} span.stamp_count`).length) {
                                            $(`.stamps.post-${id}-stamps div.stamp-${stampID} span.stamp_count`).text(data.count);
                                        }
                                    }
                                } else if(data.target === "comment") {
                                    if(data.count === 1) {
                                        $(`.comment-${id} .stamps`).append(`<div class="stamp-item comment-${stampID}-stamp multi-stamps"><img alt='${data.name}' src='${data.image}' ><span class="stamp_count">${data.count}</span></div>`);
                                        // $(".modal-title .stamps").append(`<span class="stamp-${stampID}"><img style='width:31px;' alt='${data.name}' src='${data.image}' alt=''></span>`);
                                    } else if(data.count > 1) {
                                        if($(`.comment-${id} .stamps div.comment-${stampID}-stamp span.stamp_count`).length) {
                                            $(`.comment-${id} .stamps div.comment-${stampID}-stamp span.stamp_count`).text(data.count);
                                        }
                                    }
                                }

                                alert("스탬프 정상 구매하였습니다");
                            },
                            error: function (err) {
                                if(err.responseJSON.errorType === "login") {
                                    alert(err.responseJSON.errorText);
                                } else if(err.responseJSON.errorType === "coin"){
                                    alert(err.responseJSON.errorText);
                                }
                            }
                        });
                    }
                }
            </script>
        </div>
    </div>
    <script id="stampListTemplate" type="text/x-jquery-tmpl">
{{--    @{{each groups}}--}}
        <li class="stamp-list">
            <button onclick="selectStamp(${stampId});">
                <img src="${stampImage}" />
                <p class="mt-1">${stampCoin}</p>
            </button>
        </li>
{{--    @{{/each}}--}}
    </script>
    <script id="selectStampTemplate" type="text/x-jquery-tmpl">
    <div class="category-data-item">
        <div class="item-header text-center">
            <img src="${image}" alt="stamp" class="item-img">
                <p class="mt-1 item-name">${name}</p>
                <p class="mt-1 item-description">${description}</p>
                <div>
                    <img style="width: 24px;" src="/image/coin_4x.png" alt="coin">
                        <span class="item-coin">${coin}</p>
                </div>
        </div>
        <div class="mt-4 item-body d-flex justify-content-end mr-2">
            <ul style="display: block">
                <li>보유 코인 : ${hasCoin}</li>
                <li>결제 코인 : ${coin}</li>
                <li>남은 코인 : ${afterPurchaseCoin}</li>
            </ul>
        </div>
        <div class="purchase-btn-section mt-4 mb-4 text-center">
            <button onclick="purchaseStamp(${id})" class="base-btn">구입</button>
        </div>
    </div>
</script>
