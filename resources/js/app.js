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

const app = new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')

window.defaultErrorHandler = (error) => {
    let message = 'Неизвестная ошибка'
    if (error.response) {
        message = error.response.data.message
    }
    app.$buefy.notification.open({
        message: message,
        duration: 10000,
        type: 'is-danger'
    })
    app.$router.push('/login')
}
