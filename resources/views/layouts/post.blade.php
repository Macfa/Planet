    <link rel="stylesheet" type="text/css" href="{{ asset('css/post/show.css') }}">
    <div class="modal-parent container-fluid">
        <div class="modal-wrap">
{{--            <div class="modal-top flex-wrap-wrap">--}}

{{--                <div class="modal-title flex-0-0-100">--}}
{{--                    <h4>--}}
{{--                        {{ $post->title }}&nbsp;&nbsp;&nbsp;&nbsp;<span class="titleSub">[<span class="commentCount">{{ $post->comments_count }}</span>]</span>--}}
{{--                    </h4>--}}
{{--                </div>--}}

{{--                <div class="write-info">--}}
{{--                    <p><span><a href="{{ route('channel.show', $post->channelID) }}">[{{ $post->channel->name }}]</a></span>&nbsp;온 <a href="{{ route('user.show', 'post') }}">{{ $post->user->name }}</a> / {{ $post->created_at->diffForHumans() }}</p>--}}
{{--                </div>--}}

{{--                <div class="modal-close">--}}
{{--                    <img src="{{ asset('image/close.png') }}" alt="닫기" />--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="modal-header flex-wrap-wrap">
                <div class="modal-title flex-0-0-100">
                    <h4>
                        {{ $post->title }}&nbsp;&nbsp;&nbsp;&nbsp;<span class="titleSub">[<span class="commentCount">{{ $post->comments_count }}</span>]</span>
                        <span>
                            @foreach($post->stampInPosts as $stamp)
                                <img style="width:31px;" src="{{ $stamp->stamp->image }}" alt="">
                                @if($stamp->count>1)
                                    {{ $stamp->count }}
                                @endif
                            @endforeach
                            </span>
                    </h4>
                </div>
                <div class="write-info">
                    <p><span><a href="{{ route('channel.show', $post->channelID) }}">[{{ $post->channel->name }}]</a></span>&nbsp;온 <a href="{{ route('user.show', 'post') }}">{{ $post->user->name }}</a> / {{ $post->created_at->diffForHumans() }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
{{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-image: url({{ asset('image/close.png') }})"></button>--}}
            </div>

            <div class="modal-body">
                <!-- 왼쪽 게시글 내용 -->
                <div class="modal-left">
                    <div class="modal-content">
                        <div class="board-text">
                            {!! $post->content !!}
                        </div>

                        <!-- 게시글 기타 기능 -->
                        <div class="board-etc-function" id="post">
                            <ul>
                                <li class="clickable items">
                                    <img id="post-upvote" onclick="voteLikeInPost({{ $post->id }},1)" class="image-sm" alt=""
                                         @if($post->existPostLike == 1)
                                             src="{{ asset('image/upvote_c.png') }}" />
                                        @else
                                            src="{{ asset('image/upvote.png') }}" />
                                        @endif
                                </li>
                                <li class="items">
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
                                <li data-bs-toggle="modal" data-bs-target="#openStampModal" class="clickable items">
                                    <img src="{{ asset('image/stamp.png') }}" class="image-sm" alt="" />

                                    <div class="function-text">
                                        <p>스탬프</p>
                                    </div>
                                </li>
                                <li class="clickable items">
                                    <img src="{{ asset('image/share.png') }}" class="image-sm" alt="" />

                                    <div class="function-text">
                                        <p>공유</p>
                                    </div>
                                </li>
                                <li class="clickable items" onclick="scrapPost({{ $post->id }})">
                                    <img class="image-sm" name="scrap" alt=""
                                         @if($post->existPostScrap == 1)
                                             src="{{ asset('image/scrap_c.png') }}" />
                                        @else
                                             src="{{ asset('image/scrap.png') }}" />
                                        @endif

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
                                @if(auth()->id()==$post->userID)
                                    <div class="ml-a items-r">
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
                            </ul>
                        </div>

                    @yield('comment')

                    <!-- 하단 기능 -->
{{--                        <div class="board-bot-function">--}}
{{--                            <div class="left-function">--}}
{{--                                <div class="page-arrow">--}}
{{--                                    <img onclick="voteLikeInPost({{ $post->id }},1)" id="post-upvote-fix" class="image-m" alt="위로"--}}
{{--                                         @if($post->existPostLike == 1)--}}
{{--                                             src="{{ asset('image/upvote_c.png') }}" />--}}
{{--                                        @else--}}
{{--                                            src="{{ asset('image/upvote.png') }}" />--}}
{{--                                        @endif--}}
{{--                                    <span class="post-like">{{ $post->likes->sum('vote') }}</span>--}}
{{--                                    <img onclick="voteLikeInPost({{ $post->id }},-1)" id="post-downvote-fix" class="image-m" alt="아래로"--}}
{{--                                         @if($post->existPostLike == -1)--}}
{{--                                             src="{{ asset('image/downvote_c.png') }}" />--}}
{{--                                        @else--}}
{{--                                            src="{{ asset('image/downvote.png') }}" />--}}
{{--                                        @endif--}}
{{--                                </div>--}}

{{--                                <img alt="stamp" class="stamp-image image-m" src="{{ asset('image/stamp.png') }}"/>--}}
{{--                                <img class="favorit-image image-m clickable" id="post-scrap" onclick="scrapPost({{ $post->id }})" alt="favorit"--}}
{{--                                     @if($post->postScrap == 1)--}}
{{--                                         src="{{ asset('image/scrap_c.png') }}" />--}}
{{--                                    @else--}}
{{--                                        src="{{ asset('image/scrap.png') }}" />--}}
{{--                                    @endif--}}
{{--                                <img src="{{ asset('image/message.png') }}" alt="message" class="message-image">--}}
{{--                            </div>--}}

{{--                            <div class="right-function">--}}
{{--                                <img src="{{ asset('image/message.png') }}" alt="message" class="message-image">--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    <!-- 오른쪽 광고배너 -->
{{--                        <div class="modal-right">--}}
{{--                            <div class="modal-banner">--}}
{{--                                <div class="banner-item">--}}
{{--                                    <h3>광고 배너</h3>--}}
{{--                                </div>--}}

{{--                                <div class="banner-item">--}}
{{--                                    <h3>광고 배너</h3>--}}
{{--                                </div>--}}

{{--                                <div class="banner-item">--}}
{{--                                    <h3>광고 배너</h3>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
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
                            <nav id="category-header">
                                @forelse(\App\Models\StampCategory::getAllCategories() as $category)
                                    <button onclick="selectCategory({{ $category->id }});">
{{--                                                                                <img style="width:25px;" src="{{ asset($category->image) }}" alt="{{ $category->name }}">--}}
                                        {{ $category->name }}
                                    </button>
                                @empty
                                    <div>데이터가 없습니다.</div>
                                @endforelse
                            </nav>
                            <div class="category-data">
                                @forelse(\App\Models\StampGroup::getDataFromCategory(1) as $group)
                                    <div>
                                        <div>
                                            <span>{{ $group->name }}</span>
                                        </div>
                                        @forelse($group->stamps as $stamp)
                                        <div>
                                            <button onclick="purchaseStamp({{ $stamp->id }}, {{ $post->id }});">
                                                {{ $stamp->name }}
                                            </button>
                                        </div>
                                        @empty
                                        @endforelse
                                    </div>
                                @empty
                                @endforelse
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
                        if(checkExist === false) {
                            $("#post-bot-function").addClass("sticky-bottom");
                        }
                    } else {
                        var checkExist = $("#post-bot-function").hasClass("sticky-bottom");
                        if(checkExist === true) {
                            $("#post-bot-function").removeClass("sticky-bottom");
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
                        url: "/post/voteLikeInPost",
                        data: { id: id, like:like },
                        type: "post",
                        success: function(data) {
                            // console.log(data);
                            clearLike();
                            selectLike(data.like);
                            $(".post-like").text(data.totalLike);
                        },
                        error: function(err) {
                            alert("추천기능에 문제가 생겨 확인 중입니다.");
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
                        url: "/post/reportPost",
                        data: { id: postID },
                        type: "post",
                        success: function(data) {
                            alert("신고되었습니다");
                        },
                        errror: function(err) {
                            alert("기능에러로 신고되지 않았습니다.");
                        }
                    });
                }
                function scrapPost(postID) {
                    if(confirm('스크랩하시겠습니까?\n기존에 스크랩을 했었다면 스크랩이 삭제됩니다')) {
                        $.ajax({
                            url: "/post/scrapPost",
                            data: { id: postID },
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
                                alert("기능에러로 스크랩되지 않았습니다.");
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
                            console.log(data);
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
                            },
                            errror: function (err) {
                                alert("기능에러로 스탬프를 불러오지 못 했습니다.");
                            }
                        });
                    }
                }
            </script>
        </div>
    </div>
    <script id="stampDataTemplate" type="text/x-jquery-tmpl">
    </script>
