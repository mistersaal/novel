import '../sass/app.scss'
import './bootstrap'
import store from './store'
window.store = store
import router from './router'
import Buefy from 'buefy'

import Vue from 'vue'
Vue.config.productionTip = false
Vue.use(Buefy, {})

import App from "./App.vue";

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
