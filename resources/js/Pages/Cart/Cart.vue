<script>
import { mapStores, defineStore, mapActions } from 'pinia';
import { useStore } from '@/store';
import { Head } from '@inertiajs/inertia-vue3';
import Nav from "@/Layouts/Nav.vue";
import axiosClient from "axios";


const useUserStore = defineStore('store', useStore);

export default {
    props: {
        products: Object,
        cartitems: Object,
        total: Number,
        cartItemsCount: Number
    },
    computed: {
    ...mapStores(useUserStore)
  },
    methods: {
        ...mapActions(useStore, ['showToast']),
        changeQuantity(product, qty) {
            axiosClient.post(product.updateQuanityUrl, { quantity: qty })
                .then(result => {
                    this.storeStore.CartCount = result.data.count;
                    this.showToast(true, "The item quantity was updated");
                })
        },
        removeItemFromCart(product) {
            console.log(this.productsArray);
            axiosClient.post(product.removeUrl)
                .then(result => {
                    this.showToast(true, "The item was removed from cart");
                    this.storeStore.CartCount = result.data.count;
                })
        }
    }
}

</script>

<template>
    <Nav :loggedIn="loggedIn" />

    <Head title="product" />

    <p x-text="id"></p>
    <main class="p-5">
        <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
            <h1 class="text-3xl font-bold mb-6">Your Cart Items</h1>

            <div class="bg-white p-4 rounded-lg shadow">
                <!-- Product Items -->
                <div>
                    <!-- Product Item -->
                    <template v-for="product in this.products">
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
                                                class="ml-3 py-1 border-gray-200 focus:border-purple-600 focus:ring-purple-600 w-16"
                                                @change="changeQuantity(product, $event.target.value)"
                                                :value="cartitems[product.id].quantity" />
                                        </div>
                                        <a @click.prevent="removeItemFromCart(product)" href="#"
                                            class="text-purple-600 hover:text-purple-500">Remove</a>
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
                        <span class="text-xl" x-text="`$${total}`"></span>
                    </div>
                    <p class="text-gray-500 mb-6">
                        Shipping and taxes calculated at checkout.
                    </p>

                    <button type="submit" class="btn-primary w-full py-3 text-lg">
                        Proceed to Checkout
                    </button>
                </div>
            </div>
        </div>
    </main>

</template>
