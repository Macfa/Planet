@section('content')

<section id="main">
    <div class="wrap">
{{--        <article class="advertising"><a href="#"><img src="../img/test.jpg"></a></article>--}}
        <article class="board_box">
            <div class="left">
                @auth
                    <ul class="category">
                        <div class="category_title">최근 방문한 동아리</div>
                        @forelse ($visits as $visit)
                            <li class="channel_{{ $visit->channelID }}"><a href="{{ route('channel.show', $visit->channelID) }}">{{ $visit->channel->name }}</a></li>
                        @empty
                            <li><a href="{{ route('home') }}">방문채널이 없습니다.</a></li>
                        @endforelse
                    </ul>
                @endauth

                @yield('mainmenu')
                <div class="list">
                    <table>
                        <colgroup>
                            @if(blank($posts))
{{--                                <col style="width:100%;">--}}
{{--                                <col style="width:40px;">--}}
{{--                                <col style="width:75px;">--}}
{{--                                <col style="width:100%;">--}}
                            @else
                                <col style="width:40px;">
                                <col style="width:75px;">
                                <col style="width:100%;">
                            @endif
                        </colgroup>
                        @forelse ($posts as $post)
                            <tr>
                                <td>
                                    <!-- 업이면 클래스 up, 다운이면 down -->
                                    <span class="updown up">{{ $post->likes->sum('vote') }}</span>
                                </td>
                                <td>
                                    <div class="thum" style="background-image: url({{ $post->image }});"></div>
                                </td>
                                <td>
                                    <div class="title">
                                        <a href="javascript:OpenModal({{ $post->id }});">
                                            <p>{{ $post->title }}</p>
                                            <span>[{{ $post->comments_count }}]</span>
                                        </a>
                                    </div>
                                    <div class="user">
                                        <p><span><a href="{{ route('channel.show', $post->channelID) }}">[{{ $post->channel->name }}]</a></span>온 <a href="{{ route('user.show', $post->user ) }}">{{ $post->user->name }}</a> / {{ $post->created_at->diffForHumans() }}</p></div>
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
            @hasSection('sidebar')
                @yield('sidebar')
            @endif

            @hasSection('info')
                @yield('info')
            @endif
        </article>
    </div>
</section>

<script>
    // 무한 스크롤
    var page = 1;

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height()) {
            loadMoreData(page);
            page++;
        }
    });

    function loadMoreData(page) {
        var channelID = "{{ request()->route('channel') }}";
        var type = $(".tab .on").attr('value');

        $.ajax({
            url: '/mainmenu',
            type: 'get',
            data: {
                "page": page,
                'type': type,
                'channelID': channelID
            },
            success: function(data) {
                var valueList = [];
                // $("#main .wrap .left .list table tbody tr").remove();
                if(data.result.length==0) {
                    // valueList.push("<tr class='none-tr'><td>데이터가 없습니다.</td></tr>");
                    // var value = "<tr class='none-tr'><td>데이터가 없습니다.</td></tr>";
                    // $("#main .wrap .left .list table tbody").html(value);
                    toastr.info("데이터가 없습니다");
                } else {
                    for(var i=0; i<data.result.length; i++) {
                        valueList.push({
                            "totalVote": data.result[i].totalVote,
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
                    $("#mainMenuItem").tmpl(valueList).insertAfter("#main .wrap .left .list table tbody tr:last-child");
                }
                $("#main .wrap .left .tab li[class="+type+"]").attr('class', 'on');
            },
            error: function(err) {
                console.log(err);
            }
        })
    }
    // function loadMoreData(page) {
    //     $.ajax({
    //         url: '?page=' + page,
    //         type: "get",
    //         beforeSend: function() {
    //             $('.ajax-load').show();
    //         }
    //     }).done(function(data) {
    //
    //
    //         if(page == " ") {
    //             $('.ajax-load').html("No more records found");
    //             return;
    //         }
    //         $('.ajax-load').hide();
    //         $("#load_data").append(data.html);
    //
    //     }).fail(function(jqXHR, ajaxOptions, thrownError) {
    //         alert('server not responding...');
    //     });
    // }

    $('#main .tab li').click(function(event){
        $('#main .tab li').removeClass('on');
        $(this).addClass('on');
    });
    function OpenModal(id) {
        window.open('/post/'+id);
    }
    function search(type) {
        $("#searchType").val(type);
        $("#mainSearchForm").submit();
    }
    function clickMainMenu(type) {
        var channelID = "{{ request()->route('channel') }}";

        $.ajax({
            url: '/mainmenu',
            type: 'get',
            data: {
                'type': type,
                'channelID': channelID
            },
            success: function(data) {
                var valueList = [];
                $("#main .wrap .left .list table tbody tr").remove();
                if(data.result.length==0) {
                    // valueList.push("<tr class='none-tr'><td>데이터가 없습니다.</td></tr>");
                    var value = "<tr class='none-tr'><td>데이터가 없습니다.</td></tr>";
                    $("#main .wrap .left .list table tbody").html(value);
                } else {
                    for(var i=0; i<data.result.length; i++) {
                        valueList.push({
                            "totalVote": data.result[i].totalVote,
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
                    $("#mainMenuItem").tmpl(valueList).appendTo("#main .wrap .left .list table tbody");
                }
                $("#main .wrap .left .tab li[class="+type+"]").attr('class', 'on');
            },
            error: function(err) {
                console.log(err);
            }
        })
    }
</script>
<script id="mainMenuItem" type="text/x-jquery-tmpl">
<tr>
    <td>
        <span class="updown up">${totalVote}</span>
    </td>
    <td><div class="thum"></div></td>
    <td>
        <div class="title">
            <a href="javascript:OpenModal(${postID});">
                <p>${postTitle}</p>
                <span>[${commentCount}]</span>
            </a>
        </div>
        <div class="user">
            <p><span><a href="/channel/${postChannelID}">[${channelName}]</a></span>온 <a href="/user/${userID}">${userName}</a> / ${created_at_modi}</p></div>
    </td>
</tr>
{{--<p><span><a href="{{ route('channel.show', $post->channelID) }}">[{{ $post->channel->name }}]</a></span>온 <a href="{{ route('user.show', ${userName}) }}">${userName}</a> / ${created_at_modi}</p></div>--}}
</script>
@endsection
