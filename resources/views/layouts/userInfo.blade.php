@section('sidebar')
<div class="right_sub">
    <div class="info">
        마이페이지
    </div>
    <div class="info_detail">
{{--            <div class="flex">--}}
{{--                <div class="flex_item">--}}
{{--                    <div><img style="width:36px; height:36px;" src="{{ $user->avatar }}"/>ID : {{ $user->name }}</div>--}}
{{--                </div>--}}
{{--                <div class="flex_item">--}}
{{--                    <div>버튼</div>--}}
{{--                    <p>포인트 필수</p>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="">
                <img style="float: left; width:45px;" src="{{ $user->avatar }}"/>
                <div style="margin-left: 50px;">
                    <span>
                        ID : {{ $user->name }}&nbsp;&nbsp;&nbsp;&nbsp;
                        @if(auth()->id() == $user->id)
                        <!-- Button trigger modal -->
{{--                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">--}}
{{--    Launch demo modal--}}
{{--</button>--}}
                            @if($user->isNameChanged=="N")
                                <button type="button" class="sub_btn" data-bs-toggle="modal" data-bs-target="#modalModifyUserName">변경</button>
                            @endif
                        @endif
                    </span>
                    <br/>
                    <span>
                        등급 : {{ $user->grade->name }}
                    </span>
                </div>
{{--                <div class="flex_item">--}}
{{--                    <div>버튼</div>--}}
{{--                    <p>포인트 필수</p>--}}
{{--                </div>--}}
{{--                <div class="flex_item">--}}

{{--                </div>--}}
        </div>
        <div class="mt10 mb10">
            <div class="progress">
                {{-- style 계산식 입력 --}}
                <div class="progress-bar" role="progressbar" style="width: {{ ( $user->hasExperiences()->sum('exp') - $user->grade->minExp ) / $user->grade->maxExp * 100 }}%;" aria-valuenow="{{ $user->hasExperiences()->sum('exp') }}" aria-valuemin="{{ $user->grade->minExp }}" aria-valuemax="{{ $user->grade->maxExp }}">{{ $user->hasExperiences()->sum('exp') - $user->grade->minExp }}</div>
            </div>
            <div class="flex">
                <div class="cst_sp_g_12 flex_item">다음 등급까지 {{ $user->grade->maxExp - $user->hasExperiences()->sum('exp') }}xp</div>
{{--                    <div class="cst_sp_g_12 flex_item">{{ $user->grade->next_grade }}</div>--}}
{{--                    <div class="cst_sp_g_12 flex_item">{{ $user->grade->maxExp }}</div>--}}
            </div>
        </div>
{{--            <div id="progressbar">--}}

{{--            </div>--}}
        <div class="flex">
            <div class="flex_item">
                {{-- <div>{{ $post->created_at->format('Y-m-d') }}</div> --}}
                <div>{{ number_format($coin->totalCoin) }}</div>
                <p>보유코인</p>
            </div>
            <div class="flex_item">
                <div>{{ date_format($user->created_at, 'Y.m.d') }}</div>
                <p>생성일자</p>
            </div>
        </div>
        <div class="flex">
            <div class="flex_item">
                <div>{{ $coin->postCount }}</div>
                <p>게시글 수</p>
            </div>
            <div class="flex_item">
                <div>{{ number_format($coin->postCoin) }}</div>
                <p>대자보 등극 수</p>
            </div>
        </div>
        <div class="flex">
            <div class="flex_item">
                <div>{{ $coin->commentCount }}</div>
                <p>댓글 수</p>
            </div>
            <div class="flex_item">
                <div>{{ number_format($coin->commentCoin) }}</div>
                <p>베스트 댓글 수</p>
            </div>
        </div>
        <div class="flex">
            <div class="flex_item">
{{--                <a href="{{ route('user.destroy', auth()->id()) }}">삭제</a>--}}
                <a class="cst_sp_g_12" href="{{ route('user.destroy', ['id'=>auth()->id()]) }}">삭제 ( 수정 중 )</a>
            </div>
        </div>
    </div>
</div>
<div class="link">
    <div class="link_sub">
        <p>사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.</p>
        <p>어쩌면 마음이 맞는 친구를 찾을지도 모릅니다.</p>
        <ul>
            <li><a href="{{ route('post.create') }}">게시글 작성</a></li>
            <li><a href="{{ route('channel.create') }}">토픽 만들기</a></li>
        </ul>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalModifyUserName" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <form method="post" action="{{ route('user.modify', $user->id) }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">닉네임 변경</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
{{--                    <div class="form-floating mb-3 has-validation">--}}
                <div class="mb-3">
                    <input type="text" class="form-control" name="name" id="floatingName" placeholder="닉네임 입력" >
{{--                        <input type="text" class="form-control" name="name" id="floatingName" placeholder="닉네임 입력" required pattern="^[가-힣,a-z,A-Z,1-9]{2,8}$">--}}
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
            </div>
            <div class="modal-header">
                <div class="left">
                    @if($user->isNameChanged=="Y")
                        <span> 100 코인 차감</span>
                    @else
                        <span> 차감 없음</span>
                    @endif
                </div>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary">등록</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    @if (count($errors) > 0)
        $( document ).ready(function() {
            $('#modalModifyUserName').modal('show');
        });
    @endif
</script>
@endsection
