import Vue from 'vue'
import VueRouter from 'vue-router'

import AppAuthenticated from '../components/Pages/AppAuthenticated'

import AppDashboard from '../components/Pages/Dashboard/AppDashboard'
import AppUmat from '../components/Pages/Umat/AppUmat'

Vue.use(VueRouter)

const routes = [
    {
        path: '/', component: AppAuthenticated,
        children: [
            { path: '/', component: AppDashboard },
            { path: '/daftar-umat', component: AppUmat },
        ],
    },
]

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
})

export default router;