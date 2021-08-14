@section('content')

<section id="main">
    <div class="wrap">
{{--        <article class="advertising"><a href="#"><img src="../img/test.jpg"></a></article>--}}
        <article class="board_box">
            <div class="left">

                <ul class="category">
                    <div class="category_title">최근 방문한 동아리</div>
                    <li><a href="{{ route('home') }}">포디엄</a></li>
                    @foreach ($favorites as $favorite)
                        <li class="channel_{{ $favorite->channelID }}"><a href="{{ route('channel.show', $favorite->channelID) }}">{{ $favorite->channel->name }}</a></li>
                    @endforeach
                </ul>
                @if(request()->has('searchText') )
                    <ul class="tab">
                        <li @if($searchType === 'a') class="on" @endif><a href="javascript:search('a')">제목+내용</a></li>
                        <li @if($searchType === 't') class="on" @endif><a href="javascript:search('t')">제목</a></li>
                        <li @if($searchType === 'c') class="on" @endif><a href="javascript:search('c')">내용</a></li>
                    </ul>

                @elseif(request()->is('user/*'))
                    <ul class="tab">
                        <li @if( $el =="post") class="on" @endif><a href="{{ route('user.show', ['user'=>$user->id, 'el'=>'post']) }}">나의 쓴 글</a></li>
                        <li @if( $el =="comment") class="on" @endif><a href="{{ route('user.show', ['user'=>$user->id, 'el'=>'comment']) }}">나의 쓴 댓글</a></li>
                        <li @if( $el =="scrap") class="on" @endif><a href="{{ route('user.show', ['user'=>$user->id, 'el'=>'scrap']) }}">나의 스크랩</a></li>
                    </ul>
                @else
                    <ul class="tab_title">
                        {{ (isset($channel)) ? $channel->name:'포디엄'  }}
                    </ul>
                    <ul class="tab">
                        <li class="on clickable realtime" onclick="clickMainMenu('realtime');"><a>실시간</a></li>
                        <li class="clickable hot" onclick="clickMainMenu('hot');"><a>인기</a></li>
                    </ul>
                @endif
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
                                <td><div class="thum"></div></td>
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
                                    데이터가 없습니다.
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
