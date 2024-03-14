<div class="collapse" id="header-mypage" style="z-index:2000; position:absolute; right:2%; top:6.5%; width:15%">
    <div class="list-group" style="border-radius: 1rem;">
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'post']) }}" class="list-group-item list-group-item-action" aria-current="true">
            내가 쓴 글
        </a>
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'comment']) }}" class="list-group-item list-group-item-action">내가 쓴 댓글</a>
        <a href="{{ route('user.show', ['user'=>auth()->id(), 'el'=>'scrap']) }}" class="list-group-item list-group-item-action">스크랩</a>
    </div>
</div>
