@section('sidebar')
<div class="best">
    <ul>
        <li class="clickable realtime" onclick="clickSidebarMenu('realtime');"><a>인기</a></li>
        <li class="clickable hot" onclick="clickSidebarMenu('hot');"><a>화제</a></li>
    </ul>
    <ol class="sidebar_list">
    </ol>
</div>
<div class="sidebar-sticky link">
    <div class="link_sub">
        <p>사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.</p>
        <p>어쩌면 마음이 맞는 친구를 찾을지도 모릅니다.</p>
        <ul>
            @auth
                <li><a href="{{ route('post.create') }}">게시글 작성</a></li>
                <li><a href="{{ route('channel.create') }}">동아리 만들기</a></li>
            @endauth
            @guest
                <li><a href="javascript:notLogged();">게시글 작성</a></li>
                <li><a href="javascript:notLogged();">동아리 만들기</a></li>
            @endguest
        </ul>
    </div>
</div>
{{--<div style="position: sticky; top: calc(100vh - 8px); transform: translateY(-100%);">--}}
{{--    <button class="btn btn-primary" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">맨 위로</button>--}}
{{--</div>--}}
<script>
    function clickSidebarMenu(type) {
        $.ajax({
            url: '/sidebar',
            type: 'get',
            data: { 'type': type },
            success: function(data) {
                var beAppendVariable = '';

                for(var i=0; i<5; i++) {
                    if(data.length > i) {
                        beAppendVariable += '<li><a href="/post/'+data[i].id+'"><span class="up">'+data[i].totalVote+'</span><p>'+data[i].title+'</p></a></li>';
                    } else {
                        beAppendVariable += '<li><a href="/"><p>추천 동방이 없습니다.</p></a></li>';
                    }
                }
                $(".sidebar_list>li").remove();
                $(".right .best>ul>li[class="+type+"]").attr('class', 'on');
                $(".sidebar_list").append(beAppendVariable);
            },
            error: function(err) {
                console.log(err);
            }
        })
    }
</script>
@endsection
