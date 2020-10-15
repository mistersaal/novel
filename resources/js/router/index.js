import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import Novel from "../views/Novel"

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
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
