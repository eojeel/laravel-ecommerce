import { defineStore } from 'pinia'
import state from './state'
/** import * as actions from './actions' **/
/** import * as mutations from './mutations'**/
import axiosClient from "axios"

export const useStore =  defineStore({
    id: 'store',
    state: () => {
    return state
    },
    getters: {},
    mutations: {},
    actions: {
        async getProducts() {
            this.setProducts(true)
            return axiosClient.get('/api/products')
            .then(res => {
                this.setProducts(false, res.data)
            })
            .catch(() => {
                this.setProducts(false)
            })
        },
        setProducts(loading, response = {}) {
            this.products.loading = loading;
            this.products.data = response.data;
        }
    },
})
