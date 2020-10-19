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
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
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
