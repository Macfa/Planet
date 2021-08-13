@section('info')
<div class="right">
    <div class="right_sub">
        <div class="info">
            레닛정보
        </div>
{{--        {{dd($posts)}}--}}
        <div class="info_detail">
            <p class="description">{{ $channel->description }}</p>
            <div class="flex">
                <div class="flex_item">
                    <div>{{ $channel->user->name }}</div>
                    <p>관측자</p>
                </div>
                <div class="flex_item">
                    {{-- <div>{{ $post->created_at->format('Y-m-d') }}</div> --}}
                    <div>{{ date('Y년 m월 d일', strtotime($channel->created_at)) }}</div>
                    <p>최초 관측일</p>
                </div>
            </div>
            <div class="flex">
                <div class="flex_item">
                    <div class="totalCount">{{ $channel->favorites_count }}</div>
                    <p>거주자</p>
                </div>
            </div>
            @if(auth()->id()==$channel->userID)
            <div class="flex">
                <li class="flex_item">
                    <a href="{{ route('channel.edit', $channel->id) }}">수정</a>
                </li>
                <li class="flex_item">
                    <button onclick="deleteChannel({{ $channel->id }})">삭제</button>
{{--                    <form action="{{ route('channel.destroy', $channel->id) }}" method="post">--}}
{{--                        @csrf--}}
{{--                        @method('delete')--}}
{{--                        <button type="submit">--}}
{{--                            삭제--}}
{{--                            <a>삭제</a>--}}
{{--                        </button>--}}
{{--                    </form>--}}
                </li>
            </div>
            @endif
        </div>
    </div>
    <div class="link">
        <p>사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.</p>
        <p>어쩌면 마음이 맞는 친구를 찾을지도 모릅니다.</p>
        <ul>
            @if($channel->userID != auth()->id())
                <li><a class="favorite_btn clickable" onclick="addFavorite({{ $channel->id }})">가입/탈퇴</a></li>
            @endif
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
                    $('.category').append('<li class="channel_'+data.channel.id+'"><a href="'+url+'"><img src="../img/icon_podium.png">'+data.channel.name+'</a></li>');
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
