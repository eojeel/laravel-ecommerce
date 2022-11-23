import axios from "axios";

export function getProducs({commit}) {
    return axios.get('products')
    .then(res => {

    })
}
