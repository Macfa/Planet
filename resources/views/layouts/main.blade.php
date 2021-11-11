@extends('layouts.master')

@section('main')
<section id="main">
    <div class="main-wrap">
        <article class="board_box row">
            <div class="left col-9">
                <button style="margin:0 30px;" onclick="willRemove();">Unread</button>
                <button onclick="location.href='/test'">Coin</button>
                    <ul class="category">
                        <div class="category_title">최근 방문한 동아리</div>

{{--                        @auth--}}
                            @forelse($channelVisitHistories as $history)
                                <li class="channel_{{ $history->channel_id }}"><a href="{{ route('channel.show', $history->channel_id) }}">{{ $history->channel->name }}</a></li>
                            @empty
                                <li><a href="{{ route('home') }}">방문채널이 없습니다.</a></li>
                            @endforelse
{{--                        @endauth--}}
                    </ul>


                @hasSection('content-mainmenu')
                    @yield('content-mainmenu')
                @endif
                @hasSection('content-search')
                    @yield('content-search')
                @endif
                @hasSection('content-mypage')
                    @yield('content-mypage')
                @endif
{{--                @yield('content-menu')--}}

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
                                    <span class="updown up">{{ $post->likes->sum('like') }}</span>
                                </td>
                                <td>
                                    <div class="thum" style="background-image: url({{ $post->image }});"></div>
                                </td>
                                <td>
                                    <div class="title">
                                        <a href="#post-show-{{ $post->id }}" data-bs-toggle="modal" data-bs-focus="false" data-bs-post-id="{{ $post->id }}" data-bs-channel-id="{{ $post->channel->id }}" data-bs-target="#open_post_modal">
                                            <p>{{ $post->title }}&nbsp;&nbsp;</p>
                                            @if($post->comments->count() > 0)
                                                <span class="titleSub">[<span class="commentCount">{{ $post->comments->count() }}</span>]</span></p>
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
            </div>
            <div class="right col-3">
                @yield('sidebar')
            </div>
        </article>
    </div>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
    <script id="mainMenuItem" type="text/x-jquery-tmpl">
    <tr id="post-${postID}">
        <td>
            <span class="updown up">${totalLike}</span>
        </td>
        <td><div class="thum"></div></td>
        <td>
            <div class="title">
                <a href="" data-bs-toggle="modal" data-bs-post-id="${postID}" data-bs-target="#open_post_modal">
                <p>${postTitle}&nbsp;&nbsp;</p>
                @{{if commentCount > 0}}
                    <span class="titleSub">[<span class="commentCount">${commentCount}</span>]</span>
                @{{/if}}
                </a>
            </div>
            <div class="user">
                <p><span><a href="/channel/${postChannelID}">[ ${channelName} ]</a></span> ${created_at_modi} / <a href="/user/${userID}">${userName}</a></p></div>
        </td>
    </tr>
    </script>
    <script id="dataPlaceHolder" type="text/x-jquery-tmpl">
    <tr>
        <td>
            <span class="updown up"></span>
        </td>
        <td><div class="thum"></div></td>
        <td>
            <div class="title">
                <p class="placeholder col-6"></p>
            </div>
            <div class="user">
                <p class="placeholder col-4"></p>
            </div>
        </td>
    </tr>
    </script>
@endpush
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/post/show.css') }}">
@endpush
