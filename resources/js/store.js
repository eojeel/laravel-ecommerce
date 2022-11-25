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
        async getProducts(url = null) {
            this.setProducts(true)
            url = url || '/api/products';
            return axiosClient.get(url)
            .then(res => {
                this.setProducts(false, res.data)
            })
            .catch(() => {
                this.setProducts(false)
            })
        },
        setProducts(loading, response = null) {
            if(response) {
                this.products = {
                    data: response.data,
                    links: response.meta.links,
                    total: response.meta.total,
                    limit: response.meta.per_page,
                    from: response.meta.from,
                    to: response.meta.to,
                    page: response.meta.current_page,
                }
            }
            this.products.loading = loading;
        }
    },
})
