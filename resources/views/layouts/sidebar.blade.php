@section('sidebar')

<style>
    .right .best>ul>li {
        cursor: pointer;
    }
</style>
<div class="right">
    <div class="best">
        <ul>
            <li class="realtime" onclick="clickSidebarMenu('realtime');"><a>실시간</a></li>
            <li class="hot" onclick="clickSidebarMenu('hot');"><a>인기</a></li>
        </ul>
        <ol class="sidebar_list">
{{--            <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>--}}
{{--            <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>--}}
{{--            <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>--}}
{{--            <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>--}}
{{--            <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>--}}
        </ol>
    </div>
    <div class="link">
        <p>사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.</p>
        <p>어쩌면 마음이 맞는 친구를 찾을지도 모릅니다.</p>
        <ul>
            <li><a href="{{ route('post.create') }}">게시글 작성</a></li>
            <li><a href="{{ route('channel.create') }}">동아리 만들기</a></li>
        </ul>
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
                for(var i=0; i<data.length; i++) {
                    beAppendVariable += '<li><a href="/post/'+data[i].id+'"><span class="up">'+data[i].totalVote+'</span><p>'+data[i].title+'</p></a></li>';
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
