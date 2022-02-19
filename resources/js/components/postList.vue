<template>
    <div class="wrap">
      <article class="advertising"><a href="#"><img :src="'/img/test.jpg'"></a></article>
      <article class="board_box">
        <div class="left">
          <ul v-if="favorites" class="category">
            <li><a href="/"><img :src="'/img/icon_podium.png'">실시간 화제글</a></li>
            <li v-for="favorite in favorites" :key="favorite.id"><a href="#"><img :src="'/img/icon_podium.png'">{{ favorite.channel.name }}</a></li>
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
                <tr v-for="post in posts" :key="post.id">
                  <td>
                    <!-- 업이면 클래스 up, 다운이면 down -->
                    <span class="updown up" v-bind:likes="post.like">{{ post.like }}</span>
                  </td>
                  <td><div class="thum"></div></td>
                  <td>
                    <div class="title">
                      <a href="#" @click="openModal(post.id)">
                        <p>{{ post.title }}</p>
                        <span>[ {{ post.comments_count }} ]</span>
                      </a>
                    </div>
                    <div class="user">
                      <p>
                        <span>
                          <router-link :to="{ name: 'channelShow', params: { id: post.channel.id} }">
                            [ {{ post.channel.name }} ]
                          </router-link>

                        </span>온
                        <a>
                          {{ post.user.name }}
                        </a> / n분 전
                      </p>
                    </div>
                  </td>
                </tr>
            </table>
          </div>
        </div>
        <div class="right">
          <div class="best">
            <ul>
              <li :class="{on: subType===1}"><a href="#" @click="clickSubType(1)">실시간</a></li>
              <li :class="{on: subType===2}"><a href="#" @click="clickSubType(2)">인기</a></li>
            </ul>
            <ol v-if="channels">
              <li v-for="channel in channels" :key="channel.id"><a href="#"><span class="up">111</span><p>{{ channel.name }}</p></a></li>
            </ol>
          </div>
          <div class="link">
            <p>사람들과 얘기하고 싶었던 주제로 나만의 몽드를 만들어 보세요.</p>
            <p>어쩌면 마음이 맞는 친구를 찾을지도 모릅니다.</p>
            <ul>
              <li><a :href="'/post/create'">포스트 작성</a></li>
              <li><a :href="'/channel/create'">몽드 만들기</a></li>
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
            type: 1,
            subType: 1,
            posts: null,
            favorites: null,
            channels: null,
        }
    },
    mounted() {
      axios.get('/api/main').then(res => {
        this.posts = res.data[0];
        this.favorites = res.data[1];
        this.channels = res.data[2];
      })
    },
    created() {

    },
    methods: {
        clickType: function(type) {
            this.type = type;
        },
        clickSubType: function(subType) {
            this.subType = subType;
        },
        openModal: function(id) {
          window.open("/post/"+id);
        },
        // upvote(id) {
        //     axios.post("/post/upvote/"+id)
        //     .then((res) => {
        //         console.log(res);
        //     })
        //     .catch(function(err) {
        //         console.log(err);
        //     })
        // },
    }
}
</script>

