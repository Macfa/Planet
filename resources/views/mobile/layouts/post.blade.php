    <link rel="stylesheet" type="text/css" href="{{ asset('css/mobile/post/show.css') }}">
    <div class="modal-parent wid100" style="height: 100vh; background-color: #888888;">
        <div class="modal-wrap" style="background-color: #ffffff;">
            <div class="modal-header flex-wrap-wrap">
                <div class="modal-title flex-0-0-100">
                    <h4>
                        {{ $post->title }}&nbsp;&nbsp;<span class="titleSub">[&nbsp;<span class="commentCount">{{ $post->comments->count() }}</span>&nbsp;]</span>
                        <span class="stamps">
                            @foreach($post->stampInPosts as $stampInPost)
                                <span class="stamp-{{ $stampInPost->stampID }}">
                                    <img style="width:31px;" src="{{ $stampInPost->stamp->image }}" alt="">
                                    <span>
                                        @if($stampInPost->count() > 1)
                                            {{ $stampInPost->count() }}
                                        @endif
                                    </span>
                                </span>
                            @endforeach
                            </span>
                    </h4>
                </div>
                <div class="write-info">
                    <p class="sub_text"><span><a href="{{ route('channel.show', $post->channel_id) }}">[&nbsp;{{ $post->channel->name }}&nbsp;]&nbsp;</a></span> {{ $post->created_at->diffForHumans() }} / <a href="{{ route('user.show', ["user" => $post->user] ) }}">{{ $post->user->name }}</a></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
{{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-image: url({{ asset('image/close.png') }})"></button>--}}
            </div>

            <div class="modal-body">
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
                                    <li data-bs-toggle="modal" data-bs-target="#openStampModal" class="clickable items">
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
            <div class="modal fade" id="openStampModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="margin-top:250px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>스탬프 목록</h4>
{{--                            <input type="text" name="searchStamp" />--}}
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <nav id="category-header" class="flex-container">
                                    @forelse(\App\Models\StampCategory::getAllCategories() as $category)
                                        <button class="col" onclick="selectCategory({{ $category->id }});">
    {{--                                                                                <img style="width:25px;" src="{{ asset($category->image) }}" alt="{{ $category->name }}">--}}
                                            {{ $category->name }}
                                        </button>
                                    @empty
                                        <div>데이터가 없습니다.</div>
                                    @endforelse
                                    <button class="col" onclick="return false;">테스트1</button>
                                    <button class="col" onclick="return false;">테스트2</button>
                                    <button class="col" onclick="return false;">테스트3</button>
                                </nav>
                                <div id="category-data">
                                    @forelse(\App\Models\StampGroup::getDataFromCategory(1) as $group)
                                        <div>
                                            <div>
                                                <span id="group-name">{{ $group->name }}</span>
                                            </div>
                                            @forelse($group->stamps as $stamp)
                                            <div>
                                                <ul class="flex-container">
                                                    <li class="col">
                                                        <button onclick="purchaseStamp({{ $stamp->id }}, {{ $post->id }});">
                                                            <img src="{{ $stamp->image }}" />
                                                            <span>{{ $stamp->coin }}</span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    @empty
                                    @endforelse
                                    <div>
                                        <div>
                                            <span id="group-name">동물</span>
                                        </div>
                                            <div>
                                                <button onclick="return false;">
                                                    <img src="/image/2_1629657939.gif" />
                                                    <span>100</span>
                                                </button>
                                            </div>
                                    </div>
                                    <div>
                                        <div>
                                            <span id="group-name">고양이</span>
                                        </div>
                                            <div>
                                                <button onclick="return false;">
                                                    <img src="/image/2_1629657939.gif" />
                                                    <span>1500</span>
                                                </button>
                                            </div>
                                    </div>
{{--                                    테스트 영역 끝--}}
                                </div>
                            </div>
                        </div>
{{--                        <div class="modal-footer">--}}
{{--                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                            <button type="button" class="btn btn-primary">Save changes</button>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
            {{--    <script src="{{ asset('js/editorShow.js') }}"></script>--}}
            <script>
                $("#open_post_modal").scroll(function() {
                    var headerHeight = $("#header").height();
                    var postOffsetTop = $("#post").offset().top;

                    if(postOffsetTop - headerHeight <= 0 ) {
                        var checkExist = $("#post-bot-function").hasClass("sticky-bottom");
                        // console.log(checkExist);
                        if(checkExist === false) {
                            $("#post-bot-function").addClass("sticky-bottom");
                            $("#post-bot-function").removeClass("d-none");
                            // console.log($("#post-bot-function").className);
                        }
                    } else {
                        var checkExist = $("#post-bot-function").hasClass("sticky-bottom");
                        if(checkExist === true) {
                            $("#post-bot-function").removeClass("sticky-bottom");
                            $("#post-bot-function").addClass("d-none");
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
                            alert(data.responseText);
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
                function selectCategory(categoryID) {
                    // alert(categoryID);
                    $.ajax({
                        url: "/stamp",
                        data: { categoryID: categoryID },
                        type: "get",
                        success: function(data) {
                            var result = {
                                'groups': data
                            };
                            $("#openStampModal #category-data > div").remove();
                            $("#stampDataTemplate").tmpl(result).appendTo("#openStampModal #category-data");
                        },
                        errror: function(err) {
                            alert("기능에러로 스탬프를 불러오지 못 했습니다.");
                        }
                    });
                }
                function purchaseStamp(stampID, postID) {
                    if(confirm('구매하시겠습니까 ?')) {
                        $.ajax({
                            url: "/stamp/purchase",
                            data: {
                                stampID: stampID,
                                postID: postID
                            },
                            type: "post",
                            success: function (data) {
                                console.log(data);
                                $("#total_coin").text(data.currentCoin);
                                $("#openStampModal").hide();
                                if(data.method == "create") {
                                    $(".modal-title .stamps").append(`<span class="stamp-${stampID}"><img style='width:31px;' src='${data.image}' alt=''><span></span></span>`);
                                    console.log(`<span class="stamp-${stampID}"><img style='width:31px;' src="${data.image}" alt=''></span>`);
                                } else if(data.method == "update") {
                                    $(`.modal-title .stamps span[class="stamp-${stampID}"] span`).text(data.count);
                                }
                                console.log(`.modal-title .stamps span[class="stamp-${stampID}"] span`);
                                console.log(data.count);

                                toastr.info("스탬프 정상 구매하였습니다");
                            },
                            errror: function (err) {
                                toastr.warning("기능에러로 스탬프를 불러오지 못 했습니다");
                            }
                        });
                    }
                }
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
