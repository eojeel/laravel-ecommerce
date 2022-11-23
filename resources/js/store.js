import { defineStore } from 'pinia'
import state from './state'
import * as actions from './actions'
import * as mutations from './mutations'

const store =  defineStore({
    state: () => {
    return state
    },
    getters: {},
    actions: {}
})

export default store
