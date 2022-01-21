@auth
    <ul class="category">
        <div class="category_title">최근 방문한 동아리</div>
        @forelse ($visits as $visit)
            <li class="channel_{{ $visit->channelID }}"><a href="{{ route('channel.show', $visit->channelID) }}">{{ $visit->channel->name }}</a></li>
        @empty
            <li><a href="{{ route('home') }}">방문채널이 없습니다.</a></li>
        @endforelse
    </ul>
@endauth
