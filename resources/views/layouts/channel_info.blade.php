@section('info')
<div class="right">
    <div class="right_sub">
        <div class="info">
            동아리 정보
            <span style="margin-left: 80px;">
            @if(auth()->id()==$channel->userID)
                <a href="{{ route('channel.edit', $channel->id) }}">수정</a>
                <button onclick="deleteChannel({{ $channel->id }})">삭제</button>
            @endif
            </span>
        </div>
{{--        {{dd($posts)}}--}}
        <div class="info_detail">
            <p class="description">{{ $channel->description }}</p>
            <div class="flex">
                <div class="flex_item">
                    <div class="totalCount">{{ number_format($channel->favorites_count) }}</div>
                    <p>동아리 인원</p>
                </div>
                <div class="flex_item">
                    <div>{{ date('Y년 m월 d일', strtotime($channel->created_at)) }}</div>
                    <p>동아리 창단일</p>
                </div>
            </div>
            <div class="flex">
                <div class="flex_item">
                    <div>{{ $channel->user->name }}</div>
                    <p>관리자</p>
                </div>
            </div>
            @if($channel->userID != auth()->id())
                <li><a class="d-btn favorite_btn clickable" onclick="addFavorite({{ $channel->id }})">가입/탈퇴</a></li>
            @endif
        </div>
    </div>
    <div class="link">
        <p>사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.</p>
        <p>어쩌면 마음이 맞는 친구를 찾을지도 모릅니다.</p>
        <ul>

            <li><a href="{{ route('post.create', ['channelID' => $channel->id]) }}">게시글 작성</a></li>
            <li><a href="{{ route('channel.create') }}">몽드 만들기</a></li>
        </ul>
    </div>
</div>
<script>
    function deleteChannel(id) {
        if(confirm('삭제하시겠습니까 ?')) {
                $.ajax({
                    type: "DELETE",
                    url: "/channel/"+id,
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

    function addFavorite(id) {
        $.ajax({
            type: "post",
            url: "/channel/favorite",
            data: {
                'id': id
            },
            success: function(data) {
                if(data.result=='created') {
                    var url = '{{ route('channel.show', ":id") }}';
                    url = url.replace(':id', data.channelID);
                    $('.category').append('<li class="channel_'+data.channel.id+'"><a href="'+url+'">'+data.channel.name+'</a></li>');
                    $('.totalCount').text(data.totalCount);
                } else if(data.result=='deleted') {
                    $('.category li.channel_'+data.id).remove();
                    $('.totalCount').text(data.totalCount);
                }
            },
            error: function(err) {
                // console.log(err);
            }
        })
    }
</script>
@endsection
