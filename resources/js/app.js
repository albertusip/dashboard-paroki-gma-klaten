window.Vue = require('vue');
import 'material-design-icons-iconfont/dist/material-design-icons.css'

import Vuetify from 'vuetify'
import router from './routers/router.js'
import axios from 'axios'
import VueSwal from 'vue-swal'

import 'vuetify/dist/vuetify.min.css'

window.axios = axios.create({
    timeout: 3000,
})

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
