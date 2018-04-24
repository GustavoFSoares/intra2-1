import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        message: "Hello VueX",
        count: 0
    },
    mutations: { //syncro
        increment(state, payload){
            state.count+=payload
        }
    },
    actions: { //asyncro
        increment(state, payload) {
            state.commit('increment', payload)
        }
    },
    getters: {
        message(state) {
            return state.message.toUpperCase()
        },
        counter(state) {
            return state.count
        }
    },
    methods: {
        // pressed() {
        //     store.dispatch('increment', 20)
        // }
    }

})

export default store
