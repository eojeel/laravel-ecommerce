import axiosClient from "axios"

export function getProducts() {
    return axiosClient.get('anal')
    .then(res => {
        console.log(res);
    })
}
