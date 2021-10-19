@section('content')
<section style="height: calc(var(--vh, 89vh) * 89); overflow-y: scroll;" id="main">
    <div class="main-wrap">
{{--        <article class="advertising"><a href="#"><img src="../img/test.jpg"></a></article>--}}
{{--        <article class="board_box">--}}
        <article class="board_box">
            <div class="left">
                @auth
                    <ul class="category">
                        <div class="category_title">최근 방문한 동아리</div>
                        <button style="margin:0 30px;" onclick="willRemove();">Unread</button>
                        <button onclick="location.href='/test'">Coin</button>
                        @forelse ($channelVisitHistories as $channel)
                            <li class="channel_{{ $channel->channelID }}"><a href="{{ route('channel.show', $channel->channelID) }}">{{ $channel->channel->name }}</a></li>
                        @empty
                            <li><a href="{{ route('home') }}">방문채널이 없습니다.</a></li>
                        @endforelse
                    </ul>
                @endauth

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
                            <tr id="post-{{ $post->id }}">
{{--                                <td>--}}
                                    <!-- 업이면 클래스 up, 다운이면 down -->
{{--                                    <span class="updown up">{{ $post->likes->sum('like') }}</span>--}}
{{--                                </td>--}}
                                <td>
                                    <div class="thum" style="background-image: url({{ $post->image }});"></div>
                                </td>
                                <td>
                                    <div class="title">
                                        <a href="#post-show-{{ $post->id }}" data-bs-toggle="modal" data-bs-focus="false" data-bs-post-id="{{ $post->id }}" data-bs-target="#open_post_modal">
                                            <p>{{ $post->title }}&nbsp;&nbsp;</p>
                                            <span class="titleSub">[<span class="commentCount">{{ $post->comments_count }}</span>]</span>
                                            <span>
                                                @foreach($post->stampInPosts as $stamp)
                                                    <img style="width:27px;" src="{{ $stamp->stamp->image }}" alt="">
                                                    @if($stamp->count>1)
                                                        {{ $stamp->count }}
                                                    @endif
                                                @endforeach
                                            </span>
                                        </a>
                                    </div>
                                    <div class="user">
                                        <p><span><a href="{{ route('channel.show', $post->channelID) }}">[{{ $post->channel->name }}]</a></span>온 <a href="{{ route('user.show', ["user" => $post->user] ) }}">{{ $post->user->name }}</a> / {{ $post->created_at->diffForHumans() }}</p></div>
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
            <div class="right col-3">
{{--            @hasSection('sidebar')--}}
{{--                @yield('sidebar')--}}
{{--            @endif--}}

{{--            @hasSection('info')--}}
{{--                @yield('info')--}}
{{--            @endif--}}
{{--            </div>--}}
        </article>
    </div>
</section>
<section style="height: calc(var(--vh, 3vh) * 3);" id="footer" class="">
    <section class="container-fluid">
        <nav class="flex-container flex-justify-space-between">
            {{--        <li><a href="@if(auth()->check()) {{ route('post.create') }} @else javascript:notLogged(); @endif">게시글 작성</a></li>--}}
            <a href="@if(auth()->check()) {{ route('channel.create') }} @else notLogged(); @endif" class="col">동아리 만들기</a>
            <a href="javascript:$('#main').scrollTop(0);" class="col">맨 위로</a>
            <a href="@if(auth()->check()) {{ route('post.create') }} @else notLogged(); @endif" class="col">글쓰기</a>
        </nav>
    </section>
</section>

@hasSection('content-mainmenu')
    <script>
        // 무한 스크롤
        var page = 1;
        var checkRun = false;

        $(window).scroll(function(event) {
            if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                if(checkRun == false) {
                    checkRun = true;
                    loadMoreData(page);
                    page++;
                }
            }
        });

        function loadMoreData(page) {
            var channelID = "{{ request()->route('channel') }}";
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
                            toastr.info("데이터가 없습니다");
                        } else {
                            addDataPlaceHolder();
                            for (var i = 0; i < data.result.length; i++) {
                                valueList.push({
                                    "totalLike": data.result[i].totalLike,
                                    "postID": data.result[i].id,
                                    "postTitle": data.result[i].title,
                                    "commentCount": data.result[i].comments_count,
                                    "postChannelID": data.result[i].channel.id,
                                    "channelName": data.result[i].channel.name,
                                    "userName": data.result[i].user.name,
                                    "userID": data.result[i].user.id,
                                    "created_at_modi": data.result[i].created_at_modi
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
        $(window.location.hash).modal('show'); // URL 입력 확인 후 모달 오픈
        $('a[data-bs-toggle="modal"]').click(function(){
            console.log($(this).attr('href'));
            window.location.hash = $(this).attr('href');
        });
    });
    $(document).on('show.bs.modal', '#open_post_modal', function (event) {
        if (event.target.id == 'open_post_modal') {
            var button = event.relatedTarget;
            var postID = button.getAttribute('data-bs-post-id');
            var modalBody = $(".modal-content");

            $.ajax({
                url: '/post/'+postID,
                type: 'get',
                success: function(data) {
                    modalBody.html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
        // else if (event.target.id == 'openStampModal') {
        //     // do stuff when the outer dialog is hidden.
        // }
    });

    // var open_post_modal = document.getElementById('open_post_modal')
    // open_post_modal.addEventListener('show.bs.modal', function (event) {
    //     // event.stopPropagation();
    //     // Button that triggered the modal
    //
    // })

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
        var channelID = "{{ request()->route('channel') }}";

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
                    // valueList.push("<tr class='none-tr'><td>데이터가 없습니다.</td></tr>");
                    var value = "<tr class='none-tr'><td>데이터가 없습니다.</td></tr>";
                    $("#main .wrap .left .list table tbody").html(value);
                } else {
                    for(var i=0; i<data.result.length; i++) {
                        valueList.push({
                            "totalLike": data.result[i].totalLike,
                            "postID": data.result[i].id,
                            "postTitle": data.result[i].title,
                            "commentCount": data.result[i].comments_count,
                            "postChannelID": data.result[i].channel.id,
                            "channelName": data.result[i].channel.name,
                            "userName": data.result[i].user.name,
                            "userID": data.result[i].user.id,
                            "created_at_modi": data.result[i].created_at_modi
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
<tr id="post-${postID}">
    <td>
        <span class="updown up">${totalLike}</span>
    </td>
    <td><div class="thum"></div></td>
    <td>
        <div class="title">
            <a href="" data-bs-toggle="modal" data-bs-post-id="${postID}" data-bs-target="#open_post_modal">
            <p>${postTitle}&nbsp;&nbsp;</p>
            <span class="titleSub">[<span class="commentCount">${commentCount}</span>]</span>
            </a>
        </div>
        <div class="user">
            <p><span><a href="/channel/${postChannelID}">[${channelName}]</a></span>온 <a href="/user/${userID}">${userName}</a> / ${created_at_modi}</p></div>
    </td>
</tr>
{{--<p><span><a href="{{ route('channel.show', $post->channelID) }}">[{{ $post->channel->name }}]</a></span>온 <a href="{{ route('user.show', ${userName}) }}">${userName}</a> / ${created_at_modi}</p></div>--}}
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



