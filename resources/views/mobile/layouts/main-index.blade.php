@section('mainlist')
    <div class="list">
        <table>
            <colgroup>
                @if(!blank($posts))
                    <col style="width:75px;">
                    <col style="width:100%;">
                @endif
            </colgroup>
            @forelse ($posts as $post)
                <tr id="post-{{ $post->id }}" class="post-title">
                    <td>
                        <div class="thum"></div>
                    </td>
                    <td>
                        <div class="title">
                            <a href="#post-show-{{ $post->id }}" data-bs-toggle="modal" data-bs-focus="false" data-bs-post-id="{{ $post->id }}" data-bs-channel-id="{{ $post->channel->id }}" data-bs-target="#open_post_modal">
                                <p>{{ $post->title }}&nbsp;&nbsp;</p>
                                @if($post->comments->count() > 0)
                                    <span class="titleSub">[&nbsp;<span class="commentCount">{{ $post->comments->count() }}</span>&nbsp;]</span>
                                @endif

                                <span>
                                                @forelse($post->stampInPosts as $stamp)
                                        <img style="width:27px;" src="{{ $stamp->stamp->image }}" alt="">
                                        @if($stamp->count>1)
                                            {{ $stamp->count }}
                                        @endif
                                    @empty
                                    @endforelse
                                            </span>
                            </a>
                        </div>
                        <div class="user">
                            {{--                                                                                            [동아리명] n분 전 / 사용자 id--}}
                            <p><span><a href="{{ route('channel.show', $post->channel_id) }}">[ {{ $post->channel->name }} ]</a></span> {{ $post->created_at->diffForHumans() }} / <a href="{{ route('user.show', ["user" => $post->user] ) }}">{{ $post->user->name }}</a></p></div>
                        {{--                                        <p><span><a href="{{ route('channel.show', $post->channel_id) }}">[{{ $post->channel->name }}]</a></span>온 <a href="{{ route('user.show', ["user" => $post->user] ) }}">{{ $post->user->name }}</a> / {{ $post->created_at->diffForHumans() }}</p></div>--}}
                    </td>
                </tr>
            @empty
                <tr class="none-tr">
                    <td>
                        @yield('mobile.message')
                    </td>
                </tr>
            @endforelse
        </table>
    </div>
@endsection
