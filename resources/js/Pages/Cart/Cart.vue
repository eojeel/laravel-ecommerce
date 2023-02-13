<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { useStore } from '@/store';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import axiosClient from "axios"

const store = useStore();

const props = defineProps({
    products: Object,
    cartitems: Object,
    total: Number,
    cartItemsCount: Number
});
const products = reactive(props.products);

function removeItemFromCart(product) {
    axiosClient.post(product.removeUrl)
        .then(result => {
            this.store.showToast(true, "The item was removed from cart");
            this.store.CartCount = result.data.count;
            delete this.products[product.id];
        })
}

function checkout() {
    axiosClient.post('/checkout')
        .then(result => {
            window.location.href = result.data
        })
        .catch(error => {
            store.showToast(true, 'Please Login to Checkout!');
        })
}

</script>

<template>
    <DefaultLayout :cartItemsCount="cartItemsCount">

        <Head title="product" />

        <p x-text="id"></p>
        <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
            <h1 class="text-3xl font-bold mb-6">Your Cart Items</h1>

            <div class="bg-white p-4 rounded-lg shadow">
                <!-- Product Items -->
                <div>
                    <!-- Product Item -->
                    <template v-for="product in products">
                        <div>
                            <div class="w-full flex flex-col sm:flex-row items-center gap-4">
                                <a href="/src/product.html"
                                    class="w-36 h-32 flex items-center justify-center overflow-hidden">
                                    <img :src="product.image" class="object-cover" :alt="product.title" />
                                </a>
                                <div class="flex-1 flex flex-col justify-between">
                                    <div class="flex justify-between mb-3">
                                        <h3>{{ product.title }}</h3>
                                        <span class="text-lg font-semibold">
                                            $<span>{{ product.price }}</span>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            Qty:
                                            <input :product="product" type="number"
                                                class="ml-3 py-1 border-gray-200 focus:border-emerald-600 focus:ring-emerald-600 w-16"
                                                @change="store.changeQuantity(product, $event.target.value)"
                                                :value="cartitems[product.id].quantity" />
                                        </div>
                                        <a @click.prevent="removeItemFromCart(product)" href="#"
                                            class="text-emerald-600 hover:text-emerald-500">Remove</a>
                                    </div>
                                </div>
                            </div>
                            <!--/ Product Item -->
                            <hr class="my-5" />
                        </div>
                    </template>
                    <!-- Product Item -->
                </div>
                <!--/ Product Items -->

                <div class="border-t border-gray-300 pt-4">
                    <div class="flex justify-between">
                        <span class="font-semibold">Subtotal</span>
                        <span class="text-xl">${{ total }}</span>
                    </div>
                    <p class="text-gray-500 mb-6">
                        Shipping and taxes calculated at checkout.
                    </p>

                    <form @submit.prevent="checkout">
                        <button type="submit" class="btn-primary w-full py-3 text-lg">
                            Proceed to Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>
