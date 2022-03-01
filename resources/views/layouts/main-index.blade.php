@section('mainlist')

<div class="list">
    <table>
        <colgroup>
            @if(!blank($posts))
                <col style="width:40px;">
                <col style="width:75px;">
                <col style="width:100%;">
            @endif
        </colgroup>
        @forelse ($posts as $post)
            <tr id="post-{{ $post->id }}">
                <td>
                    <!-- 업이면 클래스 up, 다운이면 down -->
                    <span class="post-like-main
                        @if($post->likes->sum('like') > 0)
                            updown up
                        @elseif($post->likes->sum('like') < 0)
                            updown down
                        @else
                            updown dash
                        @endif
                        ">{{ $post->likes->sum('like') }}</span>
                </td>
                <td>
                    <div class="thum" style="background-image: url({{ $post->image }});"></div>
{{--                    <div class="thum"></div>--}}
                </td>
                <td>
                    <div class="title">
                        <a href="#{{ $post->id }}" data-focus="false" data-bs-toggle="modal" data-bs-focus="true" data-bs-post-id="{{ $post->id }}" data-bs-channel-id="{{ $post->channel->id }}" data-bs-target="#open_post_modal">
                            <p>{{ $post->title }}&nbsp;&nbsp;</p>
                            @if($post->comments->count() > 0)
                                <span class="titleSub">[&nbsp;<span class="commentCount">{{ $post->comments->count() }}</span>&nbsp;]</span></p>
                            @endif
                        </a>
                    </div>
                    <div class="stamps post-{{ $post->id }}-stamps">
                        @foreach($post->stampsCount as $stamp)
                            <div class="stamp-item stamp-{{ $stamp->stamp_id }}
                            @if($stamp->totalCount>1)
                                multi-stamps">
                            @else
                                ">
                            @endif
                                <img src="{{ $stamp->image }}" alt="">
                                @if($stamp->totalCount>1)
                                    <span class="stamp_count">{{ $stamp->totalCount }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="user">
                        <p><span><a href="{{ route('channel.show', $post->channel_id) }}">[ {{ $post->channel->name }} ]</a></span> {{ $post->created_at->diffForHumans() }} / <a href="{{ route('user.show', ["user" => $post->user] ) }}">{{ $post->user->name }}</a></p></div>
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
@endsection
