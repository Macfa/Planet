<template>
    <section id="main">
    <div class="wrap" id="channel">
      <article class="advertising"><router-link :to="{ path: '/'}"><img :src="'/img/test.jpg'"></router-link></article>
      <article class="board_box">
        <div class="left">
          <ul v-if="favorites.length" class="category">
            <li><router-link :to="{ path: '/'}"><img :src="'/img/icon_podium.png'">포디엄</router-link></li>
            <li v-for="favorite in favorties" :key="favorite.id"><router-link :to="{ path: '/channel/:id', params: { id: favorite.channel.id }}"><img :src="'/img/icon_podium.png'">{{ favorite.channel.name }}</router-link></li>
          </ul>
          <div class="add_planet">
            <a href="#" @click="addFavorite( channel.id )">레닛 추가</a>
          </div>
          <ul class="tab">
            <li :class="{on: type===1}"><a href="" @click="clickType(1)">실시간</a></li>
            <li :class="{on: type===2}"><a href="" @click="clickType(2)">인기</a></li>
          </ul>
          <div class="list">
            <table v-if="posts.length">
              <colgroup>
                <col style="width:40px;">
                <col style="width:75px;">
                <col style="width:*;">
              </colgroup>
              <tr v-for="post in posts" :key="post.id">
                <td>
                  <!-- 업이면 클래스 up, 다운이면 down -->
                  <span class="updown up">{{ post.like }}</span>
                </td>
                <td><div class="thum"></div></td>
                <td>
                  <div class="title">
                    <a>
                      <p>{{ post.title }}</p>
                      <span>[{{  post.comments_count  }}]</span>
                    </a>
                  </div>
                  <div class="user">
                    <p><span><router-link :to="{ path:'/channel/:id', params:{ id: post.channelID } }">[{{ post.channel.name }}]</router-link></span>온 <a>{{ post.memberID }}</a> / n분 전</p>
                  </div>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <div class="right">
          <div class="right_sub">
            <div class="info">
              레닛정보
            </div>
            <div class="info_detail">
              <p class="description">{{ channel.description }}</p>
              <div class="flex">
                <div class="flex_item">
                  <div>11,000</div>
                  <p>거주자</p>
                </div>
                <div class="flex_item">
                  <div>{{ date('Y년 m월 d일', strtotime(channel.created_at)) }}</div>
                  <p>최초 관측일</p>              
                </div>
              </div>
              <div class="flex">
                <div class="flex_item">
                  <div>nickname</div>
                  <p>{{ channel.owner }}</p>
                </div>
              </div>              
            </div>
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
  </section>
</template>

<script>
export default {
    data() {
        return {
            type: 1,
            subType: 1,
            posts: null,
            favorites: null,
            channel: null,
        }
    },
    mounted() {
      axios.get('/api/channel').then(res => {
        this.posts = res.data[0];
        this.channel = res.data[1];
        this.favorites = res.data[2];
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

