@section('sidebar')
<div class="best">
    <ul>
        <li class="clickable realtime" onclick="clickSidebarMenu('realtime');"><a>실시간</a></li>
        <li class="clickable hot" onclick="clickSidebarMenu('hot');"><a>인기</a></li>
    </ul>
    <ol class="sidebar_list">
{{--            <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>--}}
{{--            <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>--}}
{{--            <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>--}}
{{--            <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>--}}
{{--            <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>--}}
    </ol>
</div>
<div class="sidebar-sticky">
    <div class="link">
        <p>사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.</p>
        <p>어쩌면 마음이 맞는 친구를 찾을지도 모릅니다.</p>
        <ul>
            <li><a href="@if(auth()->check()) {{ route('post.create') }} @else javascript:notLogged(); @endif">게시글 작성</a></li>
            <li><a href="@if(auth()->check()) {{ route('channel.create') }} @else javascript:notLogged(); @endif">동아리 만들기</a></li>
        </ul>
    </div>
    <div>
        <button class="btn" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">맨 위로</button>
    </div>
</div>
<script>
    $('#main .right .best>ul li').click(function(){
        $('#main .right .best li').removeClass('on');
        $(this).addClass('on');
    });
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
    $(document).ready(function () {
        clickSidebarMenu('realtime');
    })
</script>
@endsection
