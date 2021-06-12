  @extends('layouts.app')

  @section('content')

  <section id="main">
    <div class="wrap" id="channel">
      <article class="advertising"><a href="#"><img src="../img/test.jpg"></a></article>
      <article class="board_box">
        <div class="left">
          <ul class="category">
            <li><a href="{{ route('mainHomePage') }}"><img src="../img/icon_podium.png">포디엄</a></li>
            @foreach ($favorites as $favorite)
            <li><a href="{{ route('channelShow', $favorite->channel->id) }}"><img src="../img/icon_podium.png">{{ $favorite->channel->name }}</a></li>
            @endforeach
          </ul>
          <div class="add_planet">
            <a href="#" onclick="addFavorite({{ $channel->id }})">레닛 추가</a>
            {{-- <a href="{{ route('channelAddFavorite') }}">레닛 추가</a> --}}
          </div>
          <ul class="tab">
            <li class="on"><a href="#">실시간</a></li>
            <li><a href="#">인기</a></li>
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
                    <a href="javascript:OpenModal({{ $post->id }});">
                      <p>{{ $post->title }}</p>
                      <span>[{{ $post->comments_count }}]</span>
                    </a>
                  </div>
                  <div class="user">
                    <p><span><a href="{{ route('channelShow', $post->channelID) }}">[{{ $post->channel->name }}]</a></span>온 <a href="{{ route('userMypage', 'post') }}">{{ $post->user->name }}</a> / n분 전</p>
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
              레닛정보
            </div>
            <div class="info_detail">
              <p class="description">{{ $channel->description }}</p>
              <div class="flex">
                <div class="flex_item">
                  <div>{{ $channel->favorite_count + 1 }}</div>
                  <p>거주자</p>
                </div>
                <div class="flex_item">
                  {{-- <div>{{ $post->created_at->format('Y-m-d') }}</div> --}}
                  <div>{{ date('Y년 m월 d일', strtotime($channel->created_at)) }}</div>
                  <p>최초 관측일</p>
                </div>
              </div>
              <div class="flex">
                <div class="flex_item">
                  <div>nickname</div>
                  <p>{{ $channel->owner }}</p>
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
    $('#main .tab li').click(function(event){
      $('#main .tab li').removeClass('on');
      $(this).addClass('on');
    });
    function OpenModal(id) {
      window.open('/post/'+id);
    }
    function addFavorite(id) {
      $.ajax({
        type: "post",
        url: "/channel/favorite",
        data: {
          'id': id
        },
        success: function(data) {
          if(data) {
            var url = '{{ route('channelShow', ":id") }}';
            url = url.replace(':id', data.id);
            $('.category').append('<li><a href="'+url+'"><img src="../img/icon_podium.png">'+data.channel.name+'</a></li>');
          } else {
            alert("이미 처리된 항목입니다.");
          }
        },
        error: function(err) {
          alert(err);
        }
      })
    }
  </script>

  @endsection
