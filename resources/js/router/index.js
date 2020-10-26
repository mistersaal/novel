import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import Novel from '../views/Novel'
import Login from '../views/Login'
import Register from '../views/Register'
import Verify from '../views/Verify'

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
        path: '/email/verify',
        name: 'VerifyEmail',
        component: Verify,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/novels/:id',
        name: 'Novel',
        component: Novel,
        meta: {
            requiresAuth: true,
        }
    }
]

const router = new VueRouter({
    routes
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.state.user === null) {
            if (store.state.userDataLoaded) {
                next({name: 'Login'})
            } else {
                store.subscribe((mutation, state) => {
                    if (mutation.type === 'userDataLoaded') {
                        if (store.state.user === null) {
                            next({name: 'Login'})
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

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresGuest)) {
        if (store.state.user !== null) {
            if (store.state.userDataLoaded) {
                next(from)
            } else {
                store.subscribe((mutation, state) => {
                    if (mutation.type === 'userDataLoaded') {
                        if (store.state.user !== null) {
                            next(from)
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

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresVerifiedEmail)) {
        if (store.state.user !== null && !store.state.user.hasVerifiedEmail) {
            if (store.state.userDataLoaded) {
                next({name: 'VerifyEmail'})
            } else {
                store.subscribe((mutation, state) => {
                    if (mutation.type === 'userDataLoaded') {
                        if (store.state.user !== null && !store.state.user.hasVerifiedEmail) {
                            next({name: 'VerifyEmail'})
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
