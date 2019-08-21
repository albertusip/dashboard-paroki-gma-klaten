import Vue from 'vue'
import VueRouter from 'vue-router'

import AppNotAuthenticated from '../components/Pages/AppNotAuthenticated'
import AppLogin from '../components/Auth/AppLogin'

import AppAuthenticated from '../components/Pages/AppAuthenticated'

import AppDashboard from '../components/Pages/Dashboard/AppDashboard'
import AppUmat from '../components/Pages/Umat/AppUmat'
import AppLogout from '../components/Auth/AppLogout'

Vue.use(VueRouter)

const routes = [
    {
        path: '/login', component: AppNotAuthenticated,
        children: [
            { path: '/login', component: AppLogin },
            { path: '/', redirect: '/dashboard' },
        ]
    },

    {
        path: '/', component: AppAuthenticated,
        children: [
            { path: '/', redirect: '/dashboard' },
            { path: '/dashboard', component: AppDashboard },
            { path: '/daftar-umat', component: AppUmat },
            { path: '/logout', component: AppLogout, },
            // { path: '*', redirect: '/', },
        ],
        meta: { requiresAuth: true }
    },
]

const router = new VueRouter({
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    routes,
    hashbang: false,
})

import User from '../helpers/User'
router.beforeEach(async (to, from, next) => {
    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth)) {
        try {
            if (!User.loggedIn()) {
                next({ path: '/login', replace: true })
                return
            }
            if (to.path !== '/logout') {
                await User.updateInfo()
            }
        } catch (err) {
            return
        }
    }

    next()
})

export default router;