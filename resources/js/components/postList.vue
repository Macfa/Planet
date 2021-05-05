<template>
    <div class="wrap">
      <article class="advertising"><a href="#"><img :src="'/img/test.jpg'"></a></article>
      <article class="board_box">
        <div class="left">
          <ul class="category">
            <li><a href=""><img :src="'/img/icon_podium.png'">포디엄</a></li>
            
            <!-- <li><a href="{{ route('channelShow', $favorite->channel->id) }}"><img src="../img/icon_podium.png">{{ $favorite->channel->name }}</a></li> -->
            
          </ul>
          <ul class="tab">
            <li :class="{on: type===1}"><a href="#" @click="clickType(1)">실시간</a></li>
            <li :class="{on: type===2}"><a href="#" @click="clickType(2)">인기</a></li>
          </ul>
          <div class="list">
            <table>
              <colgroup>
                <col style="width:40px;">
                <col style="width:75px;">
                <col style="width:*;">
              </colgroup>
              <!-- @forelse ($posts as $post) -->
                <tr>
                  <td>
                    <!-- 업이면 클래스 up, 다운이면 down -->
                    <span class="updown up"></span>
                  </td>
                  <td><div class="thum"></div></td>
                  <td>
                    <div class="title">
                      <a href="javascript:OpenModal();">
                        <p></p>
                        <span>[]</span>
                      </a>
                    </div>
                    <div class="user">
                      <p>
                        <span>
                          <a href="">
                            []
                          </a>
                        </span>온 
                        <a>
                          <!-- {{ $post->user->name }} -->
                        </a> / n분 전
                      </p>
                    </div>
                  </td>
                </tr>                
              <!-- @empty
                <tr>
                  <td>
                    데이터가 없습니다.
                  </td>
                </tr>
              @endforelse -->
            </table>
          </div>
        </div>
        <div class="right">
          <div class="best">
            <ul>
              <li><a>실시간</a></li>
              <li><a>인기</a></li>
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
              <li><a href="">포스트 작성</a></li>
              <li><a href="">몽드 만들기</a></li>
            </ul>
          </div>
        </div>
      </article>
    </div>    
</template>

<script>
export default {
    data() {
        return {
            type: 1
        }
    }
    // mounted: 
    // methods: {
    //     clickType: function(type) {
    //         this.type = type;
    //     }
    // }
}
</script>

