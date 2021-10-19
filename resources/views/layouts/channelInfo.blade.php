@section('info')

<div class="right_sub">
    <div class="info">
        동아리 정보
        <span style="margin-left: 80px;">
        @if(auth()->id()==$channel->userID)
            <button onclick="location.href='{{ route('channel.edit', $channel->id) }}'">수정</button>
            <button onclick="deleteChannel({{ $channel->id }})">삭제</button>
        @endif
        </span>
    </div>
{{--        {{dd($posts)}}--}}
    <div class="info_detail">
        <p class="description">{{ $channel->description }}</p>
        <div class="flex">
            <div class="flex_item">
                <div class="totalCount">{{ number_format($channel->channelJoins->count()) }}</div>
                <p>동아리 인원</p>
            </div>
            <div class="flex_item">
                <div>{{ date('Y.m.d', strtotime($channel->created_at)) }}</div>
                <p>동아리 창단일</p>
            </div>
        </div>
        <div class="flex">
            <div class="flex_item">
                <div>{{ $channel->user->name }}</div>
                <p>관리자</p>
            </div>
        </div>
        <div class="flex flex-justify-content-flex-end">
            <button data-bs-toggle="modal" data-bs-post-id="{{ $channel->id }}" data-bs-target="#open_channel_admin_modal">
{{--            <button onclick="addSubAdmin({{ $channel->id }});">--}}
                관리자 추가
            </button>
{{--            </button>--}}
        </div>
        <ul id="channelAdminList" onclick="removeChannelAdmin();">
            @forelse($channel->channelAdmins as $channelAdmin)
                <li value="{{ $channelAdmin->id }}">{{ $channelAdmin->user->name }}</li>
            @empty
                <li value="">서브 관리자가 없습니다</li>
            @endforelse
        </ul>
        @if($channel->userID != auth()->id())
            <div><a class="d-btn favorite_btn clickable" onclick="addChannelJoin({{ $channel->id }})">동아리 가입</a></div>
        @endif
    </div>
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
<div class="modal fade" data-bs-channel-id="{{ $channel->id }}" id="open_channel_admin_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="/channel/addChannelAdmin">
                @csrf
                <input type="hidden" name="channelID" value="{{ $channel->id }}" />
                <div class="modal-header">
                    <h4>서브 관리자 관리</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="searchChannelJoinSection">
                            <input type="text" list="searchChannelJoinList" class="form-control" name="ChannelJoinInput" placeholder="동아리 유저 검색" required>
{{--                            <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">--}}
                            <datalist id="searchChannelJoinList">
                            </datalist>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                    <button type="submit" class="btn btn-primary">추가</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var open_channel_admin_modal = document.getElementById('open_channel_admin_modal');
    open_channel_admin_modal.addEventListener('show.bs.modal', function (event) {
        var channelID = event.target.getAttribute('data-bs-channel-id');

        $.ajax({
            type: "get",
            url: "/channel/getUserInChannel/"+channelID,
            // data:{"id": channelID},
            success: function(data) {
                var html = '';
                $.each(data, function (idx, name) {
                    html += `<option value='${name}'></option>`;
                })
                $("#searchChannelJoinList").html(html);
            },
            error: function(err) {
                console.log(err);
            }
        })
    });
    open_channel_admin_modal.addEventListener('hidden.bs.modal', function (event) {
    // $("#open_channel_admin_modal").on("hidden.bs.modal", function() {
        $("#open_channel_admin_modal .searchChannelJoinSection datalist").removeData("bs.modal");
        $("#open_channel_admin_modal .searchChannelJoinSection input").removeData("bs.modal");
        $(this).removeData("bs.modal");
    });

    $("#channelAdminList").click(function (event) {
        console.log(event);
        console.log(event.target);
        console.log(event.target.val());

    });
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

    function addChannelJoin(id) {
        $.ajax({
            type: "post",
            url: "/channel/channelJoin",
            data: {
                'id': id
            },
            success: function(data) {
                if(data.result=='created') {
                    //
{{--                    var url = '{{ route('channel.show', ":id") }}';--}}
//                     url = url.replace(':id', data.channelID);
                    // $('.category').append('<li class="channel_'+data.channel.id+'"><a href="'+url+'">'+data.channel.name+'</a></li>');
                    $('.totalCount').text(data.totalCount);
                } else if(data.result=='deleted') {
                    // $('.category li.channel_'+data.id).remove();
                    $('.totalCount').text(data.totalCount);
                }
            },
            error: function(err) {
                // console.log(err);
            }
        })
    }
    function removeChannelAdmin() {
    }
</script>
@endsection
