<div class="collapse multi-collapse" id="header-noti" style="z-index:2000; position:fixed; right:0%; top:6.5%; width:20%">
    <div class="list-group" style="border-radius: 1rem;">
        @forelse(auth()->user()->unreadNotifications as $notification)
            <a href="/post/{{ $notification->data['post_id'] }}" class="list-group-item list-group-item-action">{{ $notification->data['msg'] }}</a>
        @empty
            <a href="" class="list-group-item list-group-item-action">알림이 없습니다</a>
        @endforelse
    </div>
</div>