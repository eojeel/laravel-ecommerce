import { defineStore } from 'pinia'
import state from './state'
import * as actions from './actions'
import * as mutations from './mutations'

export const useStore =  defineStore({
    id: 'store',
    state: () => {
    return state
    },
    getters: {},
    actions: {}
})
