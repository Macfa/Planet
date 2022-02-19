@auth
    <ul class="category">
        <div class="category_title">최근 방문한 토픽</div>
        @forelse ($visits as $visit)
            <li class="channel_{{ $visit->channel_id }}"><a href="{{ route('channel.show', $visit->channelID) }}">{{ $visit->channel->name }}</a></li>
        @empty
            <li><a href="{{ route('home') }}">방문채널이 없습니다.</a></li>
        @endforelse
    </ul>
@endauth
