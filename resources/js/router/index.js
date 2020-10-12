import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home'
import Game from "../views/Game"

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/novels/:id',
        name: 'Game',
        component: Game,
    }
]

const router = new VueRouter({
    routes
})

export default router
