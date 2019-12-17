import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import App from './components/App'
import Welcome from './components/Welcome'
import PageNotFound from "./components/PageNotFound";

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'welcome',
            component: Welcome
        },
        {path: "*", component: PageNotFound}
    ],
});

const app = new Vue({
    el: '#app',
    components: {App},
    router,
});
