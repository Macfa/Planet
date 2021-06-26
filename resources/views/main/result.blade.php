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
            <li @if( $el =="tc") class="on" @endif><a href="javascript:search('tc')">제목+내용</a></li>
            <li @if( $el =="t") class="on" @endif><a href="javascript:search('t')">제목</a></li>
            <li @if( $el =="c") class="on" @endif><a href="javascript:search('c')">내용</a></li>
          </ul>
          <div class="list">
            <table>
              <colgroup>
                <col style="width:40px;">
                <col style="width:75px;">
                <col style="width:*;">
              </colgroup>
              @forelse ($results as $result)
              <tr>
                <td>
                  <!-- 업이면 클래스 up, 다운이면 down -->
                  <span class="updown up">{{ $result->likes->sum('like') }}</span>
                </td>
                <td><div class="thum"></div></td>
                <td>
                  <div class="title">
                    <a href="javascript:OpenModal({{ $result->memberID }});">
                      <p>{{ $result->title }}</p>
                      <span>[{{ $result->comments_count }}]</span>
                    </a>
                  </div>
                  <div class="user">
                    <p><span><a href="{{ route('channelShow', $result->channelID) }}">[{{ $result->channel->name }}]</a></span>온 {{ $result->user->name }} / n분 전</p>
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
          <div class="best">
            <ul>
              <li class="on"><a href="#">실시간</a></li>
              <li><a href="#">인기</a></li>
            </ul>
            <ol>
              <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>
              <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>
              <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>
              <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>
              <li><a href="#"><span class="up">111</span><p>아프리카tv</p></a></li>
            </ol>
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
    function search(type) {
      $('#app #header form input[name=searchType]').val(type);
      $('#app #header form[name=mainSearchForm]').submit();
    }
  </script>
  @endsection
