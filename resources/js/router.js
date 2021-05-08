import Vue from 'vue'
import Router from 'vue-router'

import postList from './components/postList.vue'
import channelShow from './components/channelShow.vue'
Vue.use(Router)

const routes = [
    {
        path: '/',
        component: postList,
        name: "channelMain"
    },
    {
        path: '/channel/:id',
        component: channelShow,
        name: "channelShow"
    }
];

export default new Router({
    mode: 'history',
    routes: routes
})