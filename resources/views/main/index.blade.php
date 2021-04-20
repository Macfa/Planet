  @include('layouts.header')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/main/layout.css') }}">

  <section id="main">
    <div class="wrap">
      <article class="advertising"><a href="#"><img src="../img/test.jpg"></a></article>
      <article class="board_box">
        <div class="left">
          <ul class="category">
            <li><a href="#"><img src="../img/icon_podium.png">포디엄</a></li>
          </ul>
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
              <tr>
                <td>
                  <!-- 업이면 클래스 up, 다운이면 down -->
                  <span class="updown up">1111</span>
                </td>
                <td><div class="thum"></div></td>
                <td>
                  <div class="title">
                    <a href="#">
                      <p>제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목제목</p>
                      <span>[1111]</span>
                    </a>
                  </div>
                  <div class="user">
                    <p><span>[아프리카tv]</span>온 닉네임 / n분 전</p>
                  </div>
                </td>
              </tr>
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
              <li><a href="{{ url('/p/create') }}">포스트 작성</a></li>
              <li><a href="{{ url('/c/create') }}">몽드 만들기</a></li>
            </ul>
          </div>
        </div>
      </article>
    </div>
  </section>
</body>


</html>
