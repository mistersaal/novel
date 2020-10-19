import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import Novel from '../views/Novel'
import Login from '../views/Login'

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
        component: Login
    },
    {
        path: '/novels/:id',
        name: 'Novel',
        component: Novel,
    }
]

const router = new VueRouter({
    routes
})

export default router
