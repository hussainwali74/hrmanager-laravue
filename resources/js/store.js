//import vue

import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        counter: 1000,
        user: false
    },
    getters: {
        getCounter(state) {
            return state;
        },
        getEmail(state) {
            return state.user.email;
        },
        getUser(state) {
            return state.user;
        }
    },
    mutations: {
        changeTheCounter(state, data) {
            state.counter += data

        },
        updateUser(state, user) {
            state.user = user
        }
    },
    actions: {
        changeCounterAction({ commit }, data) {
            commit('changeTheCounter', data)
        }
    }
})


