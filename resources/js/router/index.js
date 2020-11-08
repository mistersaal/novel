import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import NovelProcess from '../views/Novel/Process'
import Novel from '../views/Novel'
import Login from '../views/Auth/Login'
import Register from '../views/Auth/Register'
import Verify from '../views/Auth/Verify'
import SendResetEmail from '../views/Auth/Password/SendResetEmail'
import NewPassword from '../views/Auth/Password/NewPassword'
import NovelCreate from '../views/Novel/Create'

const groupRoutes = (prefix, routes) => {
    return routes.map(route => {
        route.path = `${prefix}${route.path}`

        return route
    })
}

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
    ...groupRoutes('/password', [
        {
            path: '/reset',
            name: 'SendResetEmail',
            component: SendResetEmail,
            meta: {
                requiresGuest: true
            }
        },
        {
            path: '/new/:email/:token',
            name: 'NewPassword',
            component: NewPassword,
            meta: {
                requiresGuest: true
            }
        },
    ]),
    ...groupRoutes('/novels', [
        {
            path: '/create',
            name: 'NovelCreate',
            component: NovelCreate,
            meta: {
                requiresAuth: true,
                requiresVerifiedEmail: true,
            }
        },
        ...groupRoutes('/:id', [
            {
                path: '/process',
                name: 'NovelProcess',
                component: NovelProcess,
                meta: {
                    requiresAuth: true,
                }
            },
            {
                path: '',
                name: 'Novel',
                component: Novel,
                meta: {
                    requiresAuth: true,
                }
            }
        ]),
    ]),
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
                const sub = store.subscribe((mutation, state) => {
                    if (mutation.type === 'userDataLoaded') {
                        sub()
                        if (store.state.user === null) {
                            next({name: 'Login'})
                        }
                    }
                })
            }
        }
    }

    if (to.matched.some(record => record.meta.requiresGuest)) {
        if (store.state.user !== null) {
            if (store.state.userDataLoaded) {
                next(from)
            } else {
                const sub = store.subscribe((mutation, state) => {
                    if (mutation.type === 'userDataLoaded') {
                        sub()
                        if (store.state.user !== null) {
                            next(from)
                        }
                    }
                })
            }
        }
    }

    if (to.matched.some(record => record.meta.requiresVerifiedEmail)) {
        if (store.state.user !== null && !store.state.user.hasVerifiedEmail) {
            if (store.state.userDataLoaded) {
                next({name: 'VerifyEmail'})
            } else {
                const sub = store.subscribe((mutation, state) => {
                    sub()
                    if (mutation.type === 'userDataLoaded') {
                        if (store.state.user !== null && !store.state.user.hasVerifiedEmail) {
                            next({name: 'VerifyEmail'})
                        }
                    }
                })
            }
        }
    }

    next()
})

export default router
