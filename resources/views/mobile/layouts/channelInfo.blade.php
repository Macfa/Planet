@section('info')

<div class="right_sub">
    <div class="info_detail">
        <p class="description">{{ $channel->description }}</p>
        <div class="flex">
            <div class="flex_item fs-12">
                <div class="totalCount">{{ number_format($channel->channelJoins->count()) }}</div>
                <p style="font-size:12px;">동아리 인원</p>
            </div>
            <div class="flex_item fs-12">
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
        <div class="flex flex-justify-content-flex-end fs-12">
            <button data-bs-toggle="modal" data-bs-post-id="{{ $channel->id }}" data-bs-target="#open_channel_admin_modal">
{{--            <button onclick="addSubAdmin({{ $channel->id }});">--}}
                관리자 추가
            </button>
{{--            </button>--}}
        </div>
        <ul class="fs-12" id="channelAdminList" onclick="removeChannelAdmin();">
            @foreach($channel->channelAdmins as $channelAdmin)
                <li value="{{ $channelAdmin->id }}">{{ $channelAdmin->user->name }}</li>
            @endforeach
        </ul>
        @if($channel->userID != auth()->id() && auth()->check())
            <div><a class="d-btn favorite_btn clickable" onclick="addChannelJoin({{ $channel->id }})">동아리 가입</a></div>
        @endif
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
