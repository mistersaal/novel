import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import Novel from '../views/Novel'
import Login from '../views/Login'
import Register from '../views/Register'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {
            requiresGuest: true
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: {
            requiresGuest: true
        }
    },
    {
        path: '/novels/:id',
        name: 'Novel',
        component: Novel,
        meta: {
            requiresAuth: true
        }
    }
]

const router = new VueRouter({
    routes
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth || record.meta.requiresGuest)) {
        if (store.state.user === null && to.meta.requiresAuth ||
            store.state.user !== null && to.meta.requiresGuest
        ) {
            if (store.state.userDataLoaded) {
                next(to.meta.requiresAuth ? {name: 'Login'} : from)
            } else {
                store.subscribe((mutation, state) => {
                    if (mutation.type === 'userDataLoaded') {
                        if (store.state.user === null && to.meta.requiresAuth ||
                            store.state.user !== null && to.meta.requiresGuest
                        ) {
                            next(to.meta.requiresAuth ? {name: 'Login'} : from)
                        } else {
                            next()
                        }
                    }
                })
            }
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router
