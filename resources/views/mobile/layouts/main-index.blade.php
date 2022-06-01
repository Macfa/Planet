@section('mainlist')
    <div class="list no-scroll">
        <table>
            <colgroup>
                @if(!blank($posts))
                    <col style="width:75px;">
                    <col style="width:100%;">
                @endif
            </colgroup>
            @forelse ($posts as $post)
                <tr id="post-{{ $post->id }}" class="post-title" {{ ($post['notice']) ? 'style=background-color:#d7aeae' : '' }}>
                    <td style="vertical-align: top">
{{--                        <div class="thum"></div>--}}
                        <div class="thum" style="background-size: contain; background-image: url('{{ $post->image }}');"></div>
                    </td>
                    <td>
                        <div class="title">
                            <a href="#post-show-{{ $post->id }}" data-bs-toggle="modal" data-bs-focus="false" data-bs-post-id="{{ $post->id }}" data-bs-channel-id="{{ $post->channel->id }}" data-bs-target="#open_post_modal">
                                <p>{{ $post->title }}&nbsp;&nbsp;
                                    @if($post->comments->count() > 0)
                                        <span class="titleSub">[&nbsp;<span class="commentCount">{{ $post->comments->count() }}</span>&nbsp;]</span>
                                    @endif
                                </p>

                            </a>
                        </div>
                        <div class="stamps post-{{ $post->id }}-stamps">
                            @foreach($post->stampsCount as $stamp)
                                <div class="stamp-item stamp-{{ $stamp->stamp_id }} multi-stamps">
                                    <img src="{{ url($stamp->image) }}" alt="">
                                    <span class="stamp_count">{{ $stamp->totalCount }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="user">
                            {{--                                                                                            [토픽명] n분 전 / 사용자 id--}}
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
