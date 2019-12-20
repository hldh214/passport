require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import Axios from "axios";
import Swal from "sweetalert2";

Vue.use(VueRouter);

window.axios = Axios;
window.swal = Swal;

// handle access_token
axios.interceptors.request.use(
    (config) => {
        let token = localStorage.getItem('access_token');

        if (token) {
            config.headers['Authorization'] = `Bearer ${token}`;
        }

        return config;
    },

    (error) => {
        return Promise.reject(error);
    }
);

// unset revoked access_token
axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error.response.status === 401) {
        localStorage.removeItem('access_token');
        localStorage.removeItem('role');
    }

    // todo: handle all exceptions
    swal.fire(error.response.data.message);

    return Promise.reject(error);
});

import App from './components/App'
import routes from "./routes";

const router = new VueRouter({
    mode: 'history',
    routes
});

const app = new Vue({
    el: '#app',
    components: {App},
    router
});
