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
                    {{--                                    <div class="thum" style="background-image: url({{ $post->image }});"></div>--}}
                    <div class="thum"></div>
                </td>
                <td>
                    <div class="title">
{{--                        <a href="#post-show-{{ $post->id }}" data-bs-toggle="modal" data-bs-focus="false" data-bs-post-id="{{ $post->id }}" data-bs-channel-id="{{ $post->channel->id }}" data-bs-target="#open_post_modal">--}}
                        <a href="#post-show-{{ $post->id }}" data-bs-toggle="modal" data-bs-focus="true" data-bs-post-id="{{ $post->id }}" data-bs-channel-id="{{ $post->channel->id }}" data-bs-target="#open_post_modal">
                            <p>{{ $post->title }}&nbsp;&nbsp;</p>
                            @if($post->comments->count() > 0)
                                <span class="titleSub">[&nbsp;<span class="commentCount">{{ $post->comments->count() }}</span>&nbsp;]</span></p>
                            @endif
                            <span>
                                                @foreach($post->stampInPosts as $stamp)
                                    <img style="width:27px;" src="{{ $stamp->stamp->image }}" alt="">
                                    @if($stamp->count>1)
                                        {{ $stamp->count }}
                                    @endif
                                @endforeach
                                            </span>
                        </a>
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
