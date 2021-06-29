@section('info')
<div class="right">
    <div class="right_sub">
        <div class="info">
            마이페이지
        </div>
        <div class="info_detail">
            <div class="flex">
                <div class="flex_item">
                    <div><img src="{{ asset('image/close.png') }}"/>nickname</div>
                </div>
                <div class="flex_item">
                    {{-- <div>{{ $post->created_at->format('Y-m-d') }}</div> --}}
                    <div>버튼</div>
                    <p>포인트 필수</p>
                </div>
            </div>
            <br/>
            {{-- <p class="description">{{ $post->channel->description }}</p> --}}
            <div class="flex">
                <div class="flex_item">
                    {{-- {{ dd($posts->channel) }} --}}
{{--                    <div>{{ date('Y년 m월 d일', strtotime($post->channel->created_at)) }}</div>--}}
                    <p>여행출발일</p>
                </div>
                <div class="flex_item">
                    {{-- <div>{{ $post->created_at->format('Y-m-d') }}</div> --}}
                    <div>{{ $coin->totalCoin }}</div>
                    <p>보유코인</p>
                </div>
            </div>
            <div class="flex">
                <div class="flex_item">
                    <div>{{ $coin->postCount }}</div>
                    <p>포스트 수</p>
                </div>
                <div class="flex_item">
                    <div>{{ $coin->postCoin }}</div>
                    <p>포스트로 획득한 코인</p>
                </div>
            </div>
            <div class="flex">
                <div class="flex_item">
                    <div>{{ $coin->commentCount }}</div>
                    <p>댓글 수</p>
                </div>
                <div class="flex_item">
                    <div>{{ $coin->commentCoin }}</div>
                    <p>댓글로 획득한 코인</p>
                </div>
            </div>
{{--            <div class="flex">--}}
{{--                <li class="flex_item">--}}
{{--                    <a href="{{ route('channel.edit', $channel->id) }}">수정</a>--}}
{{--                </li>--}}
{{--                <li class="flex_item">--}}
{{--                    <form action="{{ route('channel.destroy', $channel->id) }}" method="post">--}}
{{--                        @csrf--}}
{{--                        @method('delete')--}}
{{--                        <button type="submit">--}}
{{--                            삭제--}}
{{--                            --}}{{--                            <a>삭제</a>--}}
{{--                        </button>--}}
{{--                    </form>--}}
{{--                </li>--}}
{{--            </div>--}}
        </div>
    </div>
    <div class="link">
        <p>사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.</p>
        <p>어쩌면 마음이 맞는 친구를 찾을지도 모릅니다.</p>
        <ul>
            <li><a href="{{ route('post.create') }}">포스트 작성</a></li>
            <li><a href="{{ route('channel.create') }}">몽드 만들기</a></li>
        </ul>
    </div>
</div>
@endsection
