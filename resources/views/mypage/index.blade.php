@extends('layouts.app')

@section('content')
  <section id="main">
    <div class="wrap">
      <article class="advertising"><a href="#"><img src="../img/test.jpg"></a></article>
      <article class="board_box">
        <div class="left">
          <ul class="category">
            <li><a href="#"><img src="../img/icon_podium.png">포디엄</a></li>
          </ul>
          <div class="add_planet">
            <a href="#">레닛 추가</a>
          </div>
          <ul class="tab">
            {{-- <li @if( basename(Request::url()) =="post") class="o1n" @endif><a href="{{ route('userMypage', 'comment') }}">쓴 댓글</a></li> --}}
            <li @if( $el =="post") class="on" @endif><a href="{{ route('userMypage', 'post') }}">쓴 글</a></li>
            <li @if( $el =="comment") class="on" @endif><a href="{{ route('userMypage', 'comment') }}">쓴 댓글</a></li>
            <li @if( $el =="scrap") class="on" @endif><a href="{{ route('userMypage', 'scrap') }}">스크랩</a></li>
          </ul>
          <div class="list">
            <table>
              <colgroup>
                <col style="width:40px;">
                <col style="width:75px;">
                <col style="width:*;">
              </colgroup>
              @forelse ($posts as $post)
              <tr>
                <td>
                  <!-- 업이면 클래스 up, 다운이면 down -->
                  <span class="updown up">{{ $post->likes->sum('like') }}</span>
                </td>
                <td><div class="thum"></div></td>
                <td>
                  <div class="title">
                    <a href="javascript:OpenModal({{ $post->memberID }});">
                      <p>{{ $post->title }}</p>
                      <span>[{{ $post->comments_count }}]</span>
                    </a>
                  </div>
                  <div class="user">
                    <p><span><a href="{{ route('channelShow', $post->channelID) }}">[{{ $post->channel->name }}]</a></span>온 {{ $post->user->name }} /
                        {{ $post->created_at->diffForHumans() }}</p>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td>
                  데이터가 없습니다.
                </td>
              </tr>
              @endforelse
            </table>
          </div>
        </div>
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
                  <div>{{ date('Y년 m월 d일', strtotime($post->channel->created_at)) }}</div>
                  <p>여행출발일</p>
                </div>
                <div class="flex_item">
                  {{-- <div>{{ $post->created_at->format('Y-m-d') }}</div> --}}
                  <div>{{ $point->totalPoint }}</div>
                  <p>보유코인</p>
                </div>
              </div>
              <div class="flex">
                <div class="flex_item">
                  <div>{{ $point->postCount }}</div>
                  <p>포스트 수</p>
                </div>
                <div class="flex_item">
                    <div>{{ $point->postPoint }}</div>
                  <p>포스트로 획득한 코인</p>
                </div>
              </div>
              <div class="flex">
                <div class="flex_item">
                  <div>{{ $point->commentCount }}</div>
                  <p>댓글 수</p>
                </div>
                <div class="flex_item">
                  <div>{{ $point->commentPoint }}</div>
                  <p>댓글로 획득한 코인</p>
                </div>
              </div>
            </div>
          </div>
          <div class="link">
            <p>사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.</p>
            <p>어쩌면 마음이 맞는 친구를 찾을지도 모릅니다.</p>
            <ul>
              <li><a href="{{ route('postCreate') }}">포스트 작성</a></li>
              <li><a href="{{ route('channelCreate') }}">몽드 만들기</a></li>
            </ul>
          </div>
        </div>
      </article>
    </div>
  </section>
  <script>
    function OpenModal(id) {
      window.open('/post/'+id);
    }
  </script>
  @endsection
