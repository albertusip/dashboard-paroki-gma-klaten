window.Vue = require('vue');
import 'material-design-icons-iconfont/dist/material-design-icons.css'

import Vuetify from 'vuetify'
import router from './routers/router.js'
import axios from 'axios'
import User from './helpers/User.js'
import VueSwal from 'vue-swal'

import 'vuetify/dist/vuetify.min.css'

window.EventBus = new Vue()

window.axios = axios.create({
    timeout: 3000,
})

window.axios.interceptors.response.use((res) => {
    if (!!res.data.error) {
        if (!!res.data.not_authenticated) {
            if (User.loggedIn()) {
                EventBus.$emit('notlogin_error');
            }
        } else {
            EventBus.$emit('internal_error');
        }
    }
    return res;
}, (error) => {
    if (error.response) {
        if (error.response.status >= 400 && error.response.status < 500) {
            EventBus.$emit('notfound_error');
        } else {
            EventBus.$emit('internal_error');
        }
        console.log();
    } else if (error.request) {
        // The request was made but no response was received
        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
        // http.ClientRequest in node.js
        console.log(error.request);
    } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message);
    }
    return Promise.reject(error);
});

Vue.prototype.$user = User;

Vue.use(Vuetify, {
    iconfont: 'md',
    // override colors
    theme: {
        primary: "#F39B41",
        black: "#030303",
        white: "#FFFFFF",
        romancewhite: "#F3F1EE",
        blue: "#2B3A4A",
        darkgreen: "#314440",
        towergrey: "#95A39C",
        darkslate: "#435551",
    }
});

Vue.use(VueSwal);

import DashboardApp from './components/DashboardApp'
const app = new Vue({
    el: '#app',
    router,
    components: {
        DashboardApp,
    },
});
