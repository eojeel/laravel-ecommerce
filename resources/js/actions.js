import axiosClient from "axios"


export function showToast(state, message) {
    this.toast.show = state;
    this.toast.message = message;
    setTimeout(() => {
        this.toast.show = false;
    }, 3000);
}
export function hideToast(state) {
    this.toast.show = false;
    this.toast.message = '';
}
export function getProducts({url = null, search = '', per_page = 10, sortField, sortDirection } = {}) {
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
}

export function getOrders({ url = null, search = '', per_page = 10, sortField, sortDirection } = {}) {
    this.setOrders(true)
    url = url || '/api/orders';
    return axiosClient.get(url, {
        params: {
            search: search,
            per_page: per_page,
            sort_field: sortField,
            sort_direction: sortDirection
        }
    })
        .then(res => {
            this.setOrders(false, res.data)
        })
        .catch(() => {
            this.setOrders(false)
        })
}

export function setProducts(loading, response = null) {
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
}

export function setOrders(loading, response = null) {
    if (response) {
        this.orders = {
            data: response.data,
            links: response.meta.links,
            total: response.meta.total,
            limit: response.meta.per_page,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.current_page,
        }
    }
    this.orders.loading = loading;
}


export function getProduct(id) {
    return axiosClient.get(`/api/products/${id}`)
}

export function createProduct(product) {
    if (product.image instanceof File) {
        const form = new FormData();
        form.append('image', product.image);
        form.append('title', product.title);
        form.append('description', product.description);
        form.append('price', product.price);
        product = form;
    }
    return axiosClient.post('/api/products', product)
}

export function updateProduct(product) {
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
    return axiosClient.post(`/api/products/${id}`, product)
}

export function deleteProduct(id) {
    return axiosClient.delete(`/api/products/${id}`)
}

export function addToCart(product, uri) {
    return axiosClient.post(uri, 1)
        .then(result => {
            this.showToast(true, "The item was added into the cart")
            this.CartItemsCount++;
        })
        .catch(response => {
            console.log(response);
        })
}

export function cartCount(cartItemsCount) {
    if (cartItemsCount > 0 && !this.CartItemsCount) {
        this.CartItemsCount = cartItemsCount;
    }
}

export function changeQuantity(product, qty) {
    axiosClient.post(product.updateQuanityUrl, { quantity: qty })
        .then(result => {
            this.CartItemsCount = result.data.count;
            this.showToast(true, "The item quantity was updated");
        })
}
