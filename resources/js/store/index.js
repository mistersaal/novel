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
        updateNovel(state, novel) {
            for (let i = 0; i < state.user.novels.length; i++) {
                if (state.user.novels[i].id === novel.id) {
                    state.user.novels[i] = novel
                }
            }
        },
        userDataLoaded(state) {
            state.userDataLoaded = true
        }
    },
    actions: {},
    modules: {}
})
