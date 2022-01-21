@section('mobile.content-mainmenu')
{{--    <ul class="tab_title accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">--}}
{{--        {{ (isset($channel)) ? $channel->name:'포디엄'  }}--}}

    @if(isset($channel))
    <ul class="tab_title accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">

    @else
        <ul class="tab_title">
    @endif
        {{ (isset($channel)) ? $channel->name:'포디엄'  }}

        @if(isset($channel) && auth()->id()==$channel->user_id)
            <span style="margin-left: 10%; color: black !important;">
                <button onclick="location.href='{{ route('channel.edit', $channel->id) }}'" class="">수정</button>
                <button onclick="deleteChannel({{ $channel->id }})" class="">삭제</button>
            </span>
        @endif
    </ul>
    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body-channelinfo">
            @yield('info')
        </div>
    </div>
    <ul class="tab">
        <li class="on clickable realtime" value="realtime" onclick="clickMainMenu('realtime');"><a>실시간</a></li>
        <li class="clickable hot" value="hot" onclick="clickMainMenu('hot');"><a>화제</a></li>
    </ul>
@endsection

@section('message')
    글이 존재하지 않아요 !
@endsection
