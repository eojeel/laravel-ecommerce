import { defineStore, mapActions } from 'pinia'
import state from './state'
/** import * as actions from './actions' **/
import * as mutations from '@/mutations';
import axiosClient from "axios"
import axios from 'axios'

export const useStore = defineStore({
    id: 'store',
    state: () => {
        return state
    },
    getters: {},
    mutations: mutations,
    actions: {
        showToast(state, message) {
            console.log(message);
            this.toast.show = state;
            this.toast.message = message;
            setTimeout(() => {
                this.toast.show = false;
              }, 3000);
        },
        hideToast(state) {
            this.toast.show = false;
            this.toast.message = '';
        },
        getProducts({ url = null, search = '', per_page = 10, sortField, sortDirection } = {}) {
            this.setProducts(true)
            url = url || '/api/products';
            return axiosClient.get(url, {
                params: {
                    search: search,
                    per_page: per_page,
                    sort_field: sortField,
                    sort_direction: sortDirection
                }
            })
                .then(res => {
                    this.setProducts(false, res.data)
                })
                .catch(() => {
                    this.setProducts(false)
                })
        },
        getProduct(id) {
            return axiosClient.get(`/api/products/${id}`)
        },
        setProducts(loading, response = null) {
            if (response) {
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
        },
        createProduct(product) {
            if (product.image instanceof File) {
                const form = new FormData();
                form.append('image', product.image);
                form.append('title', product.title);
                form.append('description', product.description);
                form.append('price', product.price);
                product = form;
            }
            return axios.post('/api/products', product)
        },
        updateProduct(product) {
            const id = product.id
            if (product.image instanceof File) {
                const form = new FormData();
                form.append('id', product.id);
                form.append('image', product.image);
                form.append('title', product.title);
                form.append('description', product.description);
                form.append('price', product.price);
                form.append('published', product.published);
                form.append('_method', 'PUT');
                product = form;
            } else {
                product._method = 'PUT';
            }
            return axios.post(`/api/products/${id}`, product)
        },
        deleteProduct(id) {
            return axios.delete(`/api/products/${id}`)
        },
        deleteProduct(id) {
            return axios.delete(`/api/products/${id}`)
        },
        addToCart(product, uri) {
            return axiosClient.post(uri, 1)
                .then(result => {
                    //this.$dispatch('cart-change', {count: result.count})
                    this.showToast(true, "The item was added into the cart")
                    this.CartCount++;
                })
                .catch(response => {
                    console.log(response);
                })
        },
        cartCount(cartItemsCount) {
            if(cartItemsCount > 0 && !this.CartCount) {
                this.CartCount = cartItemsCount;
            }
        }
    }
})
