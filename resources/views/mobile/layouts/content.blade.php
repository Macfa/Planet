@section('content')
<section style="height: calc(var(--vh, 92vh) * 92); overflow-y: scroll;" id="main">
    <div class="main-wrap">
{{--        <article class="advertising"><a href="#"><img src="../img/test.jpg"></a></article>--}}
{{--        <article class="board_box">--}}
        <article class="board_box">
            <div class="left">
{{--                @auth--}}
                    <button style="margin:0 30px;" onclick="willRemove();">Unread</button>
                    <button onclick="location.href='/test'">Coin</button>

                    <div class="category_title">최근 방문한 토픽</div>
                    <ul class="category flex-container flex-nowrap channel-history justify-content-start align-items-center">
                        <div><a href="/">실시간 화제글</a></div>
                        @foreach ($channelVisitHistories as $history)
                            @if($loop->first)
                                <span>/</span>
                            @endif
{{--                            <li style="flex: 1 1 20%; text-overflow: ellipsis;" class="history_channel_{{ $history->channel_id }}">--}}
                                <div><a href="{{ route('channel.show', $history->channel_id) }}">{{ $history->channel->name }}</a></div>
                                @if($loop->remaining)
                                    <span>/</span>
                                @endif
{{--                            </li>--}}
                        @endforeach
                    </ul>
{{--                @endauth--}}

                {{-- search, user.show, content  --}}
                @hasSection('mobile.content-mainmenu')
                    @yield('mobile.content-mainmenu')
                @endif
                @hasSection('mobile.content-search')
                    @yield('mobile.content-search')
                @endif
                @hasSection('mobile.content-mypage')
                    @yield('mobile.content-mypage')
                @endif
                <div class="list">
                    <table>
                        <colgroup>
                            @if(!blank($posts))
                                <col style="width:75px;">
                                <col style="width:100%;">
                            @endif
                        </colgroup>
                        @forelse ($posts as $post)
                            <tr id="post-{{ $post->id }}" class="post-title">
                                <td>
                                    <div class="thum"></div>
                                </td>
                                <td>
                                    <div class="title">
                                        <a href="#post-show-{{ $post->id }}" data-bs-toggle="modal" data-bs-focus="false" data-bs-post-id="{{ $post->id }}" data-bs-channel-id="{{ $post->channel->id }}" data-bs-target="#open_post_modal">
                                            <p>{{ $post->title }}&nbsp;&nbsp;</p>
                                                @if($post->comments->count() > 0)
                                                    <span class="titleSub">[&nbsp;<span class="commentCount">{{ $post->comments->count() }}</span>&nbsp;]</span>
                                                @endif

                                            <span>
                                                @forelse($post->stampInPosts as $stamp)
                                                    <img style="width:27px;" src="{{ $stamp->stamp->image }}" alt="">
                                                    @if($stamp->count>1)
                                                        {{ $stamp->count }}
                                                    @endif
                                                @empty
                                                @endforelse
                                            </span>
                                        </a>
                                    </div>
                                    <div class="user">
                                    {{--                                                                                            [토픽명] n분 전 / 사용자 id--}}
                                        <p><span><a href="{{ route('channel.show', $post->channel_id) }}">[ {{ $post->channel->name }} ]</a></span> {{ $post->created_at->diffForHumans() }} / <a href="{{ route('user.show', ["user" => $post->user] ) }}">{{ $post->user->name }}</a></p></div>
{{--                                        <p><span><a href="{{ route('channel.show', $post->channel_id) }}">[{{ $post->channel->name }}]</a></span>온 <a href="{{ route('user.show', ["user" => $post->user] ) }}">{{ $post->user->name }}</a> / {{ $post->created_at->diffForHumans() }}</p></div>--}}
                                </td>
                            </tr>
                        @empty
                            <tr class="none-tr">
                                <td>
                                    @yield('message')
                                </td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
{{--            <div class="right col-3">--}}
{{--            @hasSection('sidebar')--}}
{{--                @yield('sidebar')--}}
{{--            @endif--}}

{{--            @hasSection('info')--}}
{{--                @yield('info')--}}
{{--            @endif--}}
{{--            </div>--}}
{{--        </article>--}}
    </div>
</section>
<section style="position: absolute; bottom: 0; background: rgba(252, 252, 252, 1) !important; z-index: 2 !important; width: 100%;" id="footer" class="">
    <section class="container-fluid">
        <nav style="padding: 8px; text-align: center;" class="flex-container flex-justify-space-between">
            {{--        <li><a href="@if(auth()->check()) {{ route('post.create') }} @else javascript:notLogged(); @endif">게시글 작성</a></li>--}}
            <a href="@if(auth()->check()) {{ route('channel.create') }} @else javascript:notLogged(); @endif" class="col">토픽 만들기</a>
            <a href="javascript:$('#main').animate({ scrollTop: 0}, 300);" class="col">맨 위로</a>
            <a href="@if(auth()->check()) {{ route('post.create') }} @else javascript:notLogged(); @endif" class="col">글쓰기</a>
        </nav>
    </section>
</section>

@hasSection('mobile.content-mainmenu')
    <script>
        // 무한 스크롤
        var page = 1;
        var checkRun = false;

        function loadMoreData(page) {
            var channelID = "{{ request()->route('channel.id') }}";
            var type = $(".tab .on").attr('value');

                $.ajax({
                    url: '/mainMenu',
                    type: 'get',
                    data: {
                        "page": page,
                        'type': type,
                        'channelID': channelID
                    },
                    success: function (data) {
                        var valueList = [];
                        if (data.result.length == 0) {
                            // toastr.info("데이터가 없습니다");
                        } else {
                            addDataPlaceHolder();
                            for (var i = 0; i < data.result.length; i++) {
                                valueList.push({
                                    "totalLike": data.result[i].totalLike,
                                    "post_id": data.result[i].id,
                                    "postTitle": data.result[i].title,
                                    "commentCount": data.result[i].comments_count,
                                    "postChannelID": data.result[i].channel.id,
                                    "channelName": data.result[i].channel.name,
                                    "userName": data.result[i].user.name,
                                    "user_id": data.result[i].user.id,
                                    "created_at_modi": data.result[i].created_at_modi,
                                    "postImage": data.result[i].image,
                                });
                            }
                            delay(function() {
                                removeDataPlaceHolder();
                                $("#mainMenuItem").tmpl(valueList).insertAfter("#main .main-wrap .left .list table tbody tr:last-child");
                            }, 1500);
                        }
                        // $("#main .wrap .left .tab li[class="+type+"]").attr('class', 'on');
                    },
                    error: function (err) {
                        console.log(err);
                    }
                })
        }
        function addDataPlaceHolder() {
            $("#dataPlaceHolder").tmpl().insertAfter("#main .main-wrap .left .list table tbody tr:last-child");
        }
        function removeDataPlaceHolder() {
            $("#main .main-wrap .left .list table tbody tr:last-child").remove();
            checkRun = false;
        }
    </script>
@endif
<script>
    $(document).ready(function(){
        $(window).on('popstate', function(e) {
            if(e.type === "popstate") {
                var modalState = $("#open_post_modal").hasClass('show');
                if(modalState) {
                    $("#open_post_modal").modal("hide");
                } else {
                    let url = window.location.href;
                    var tmpPostID = url.split('/').pop();
                    if($.isNumeric(tmpPostID))
                    {
                        $(`#post-${tmpPostID} .title a`).get(0).click();
                    }
                }
            }

        });
        var checkPost = "{{ request()->route()->named("post.show") }}";
        if(checkPost === "1") {
            let url = window.location.href;
            var tmpPostID = url.split('/').pop();
            if($.isNumeric(tmpPostID))
            {
                $(`#post-${tmpPostID} .title a`).get(0).click();
            }
        }
        $(window).scroll(function(event) {
            console.log(event);
            console.log($(window).scrollTop());
            console.log($(window).height());
            console.log($(document).height());
            if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                if(checkRun == false) {
                    checkRun = true;
                    loadMoreData(page);
                    page++;
                }
            }
        });
        // $(window.location.hash).modal('show'); // URL 입력 확인 후 모달 오픈
        // $('a[data-bs-toggle="modal"]').click(function(){
        //     console.log($(this).attr('href'));
        //     window.location.hash = $(this).attr('href');
        // });
    });

    $("#open_post_modal").on('hide.bs.modal', function(event) {
        if (event.target.id === 'open_post_modal') {
            if (history.state === "modal") {
                var isOpen = $("#openStampModal").hasClass("show");
                if(isOpen) {
                    history.back();
                }
            }
        }
    });
    $("#open_post_modal").on('show.bs.modal', function(event) {
        if (event.target.id === 'open_post_modal') {
            var button = event.relatedTarget;
            var postID = button.getAttribute('data-bs-post-id');
            var modalBody = $(".modal-content");
            var urlPath = '';

            if(history.state == null) {
                urlPath = "/post/"+postID;
            } else {
                urlPath = location.href;
            }


            $.ajax({
                url: '/post/'+postID+"/get",
                type: 'get',
                success: function(data) {
                    modalBody.html(data);
                    history.pushState('modal', 'modal', urlPath);
                    var readPost = JSON.parse(localStorage.getItem('readPost'));

                    if(readPost === null)
                    {
                        // 읽은 게시글이 없으면 새로 추가
                        localStorage.setItem('readPost', JSON.stringify([postID]));
                    } else
                    {
                        //
                        var checkExist = readPost.includes(postID.toString());
                        if (checkExist === false)
                        {
                            readPost.push(postID);
                            localStorage.setItem('readPost', JSON.stringify(readPost));
                        }
                    }
                    var readPosts = JSON.parse(localStorage.getItem('readPost'));
                    setCookie("readPost", readPosts);
                    addReadPost(postID);
                },
                error: function(err) {
                    console.log(err);
                }
            })
        } else if (event.target.id === 'openStampModal') {
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
                        $("#openStampModal input[name=type]").val(type);
                        $("#openStampModal input[name=id]").val(id);
                        $("#category-data .stamp-list:first button").click();
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    });

    $('#main .tab li').click(function(event){
        $('#main .tab li').removeClass('on');
        $(this).addClass('on');
    });
    function willRemove() {
        location.href = "/test2";
    }
    function getSearchCategory(type) {
        $("#searchType").val(type);
        $("#mainSearchForm").submit();
    }
    function clickMainMenu(type) {
        var channelID = "{{ request()->route('channel.id') }}";

        $.ajax({
            url: '/mainMenu',
            type: 'get',
            data: {
                'type': type,
                'channelID': channelID
            },
            success: function(data) {
                var valueList = [];
                $("#main .main-wrap .left .list table tbody tr").remove();
                if(data.result.length==0) {
                    var value = "<tr class='none-tr'><td>데이터가 없습니다.</td></tr>";
                    $("#main .wrap .left .list table tbody").html(value);
                } else {
                    for(var i=0; i<data.result.length; i++) {
                        valueList.push({
                            "totalLike": data.result[i].totalLike,
                            "post_id": data.result[i].id,
                            "postTitle": data.result[i].title,
                            "commentCount": data.result[i].comments_count,
                            "postChannelID": data.result[i].channel.id,
                            "channelName": data.result[i].channel.name,
                            "userName": data.result[i].user.name,
                            "user_id": data.result[i].user.id,
                            "stampInPosts": data.result[i].stamp_in_posts,
                            "created_at_modi": data.result[i].created_at_modi,
                            "postImage": data.result[i].image,
                        });
                    }
                    $("#mainMenuItem").tmpl(valueList).appendTo("#main .main-wrap .left .list table tbody");
                }
                page = 1;
                $("#main .wrap .left .tab li[class="+type+"]").attr('class', 'on');
            },
            error: function(err) {
                console.log(err);
            }
        })
    }
</script>
<script id="mainMenuItem" type="text/x-jquery-tmpl">
<tr id="post-${post_id}" class="post-title">
    <td>
        <div class="thum" style="background-image: url(${postImage});"></div>
    </td>
    <td>
        <div class="title">
            <a href="#post-show-${post_id}" data-bs-toggle="modal" data-bs-focus="false" data-bs-post-id="${post_id}" data-bs-channel-id="${postChannelID}" data-bs-target="#open_post_modal">
                <p>${postTitle}&nbsp;&nbsp;</p>
                @{{if commentCount > 0}}
                    <span class="titleSub">[&nbsp;<span class="commentCount">${commentCount}</span>&nbsp;]</span>
                @{{/if}}
{{--                <span>--}}
{{--                    @{{each(i,stamp) stampInPosts}}--}}
{{--                    ${stamp.id}--}}
{{--                            <img style="width:27px;" src="${stamp.image}" alt="">--}}
{{--                    @{{/each}}--}}
{{--                </span>--}}
            </a>
        </div>
        <div class="user">
            <p><span><a href="/channel/${postChannelID}">[ ${channelName} ]</a></span> ${created_at_modi} / <a href="/user/${userID}">${userName}</a></p></div>
        </div>
    </td>
</tr>
</script>
<script id="dataPlaceHolder" type="text/x-jquery-tmpl">
<tr>
    <td>
        <span class="updown up"></span>
    </td>
    <td><div class="thum"></div></td>
    <td>
        <div class="title">
            <p class="placeholder col-6"></p>
        </div>
        <div class="user">
            <p class="placeholder col-4"></p>
        </div>
    </td>
</tr>
</script>
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/mobile/post/show.css') }}">
@endpush
