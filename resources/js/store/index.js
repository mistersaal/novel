import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        user: null,
        userDataLoaded: false,
    },
    mutations: {
        setUser(state, user) {
            state.user = user
        },
        addUserNovel(state, novel) {
            state.user.novels.push(novel)
        },
        userDataLoaded(state) {
            state.userDataLoaded = true
        }
    },
    actions: {},
    modules: {}
})
