import axiosClient from "axios"

export function getProducts({commit}) {
    return axiosClient.get('products')
    .then(res => {

    })
}
