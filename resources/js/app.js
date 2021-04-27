require('./bootstrap');
import App from './comment.vue'

let test = {
    template: '<div>사용자 정의 컴포넌트 입니다!</div>'
  }

const app = new Vue({
    el: '#comment-list',
    data:  {
        tit: "hihi"
    },
    components: {
        template: App
    }
});
