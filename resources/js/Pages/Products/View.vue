<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { useStore } from '@/store';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const store = useStore();

const props = defineProps({
    product: Object,
    cartItemsCount: Number,
});

store.cartCount(props.cartItemsCount);

const products = computed(() => props.products);

let summary = false;
</script>
<template>
    <button @click="awesome = !awesome">Toggle</button>

    <h1 v-if="awesome">Vue is awesome!</h1>
    <h1 v-else>Oh no 😢</h1>

        <Head title="product" />
        <p x-text="id"></p>

        <section>
            <div class="relative max-w-screen-xl px-4 py-8 mx-auto">
                <div class="grid items-start grid-cols-1 gap-8 md:grid-cols-2">
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-1">
                        <img :alt="product.title" :src="product.image"
                            class="object-cover w-full aspect-square rounded-xl" />

                        <div class="grid grid-cols-2 gap-4 lg:mt-4">
                            <!--
          <img
            alt="Les Paul"
            src="https://images.unsplash.com/photo-1456948927036-ad533e53865c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80"
            class="object-cover w-full aspect-square rounded-xl"
          />
          -->
                        </div>
                    </div>

                    <div class="sticky top-0">

                        <strong
                            class="rounded-full border border-blue-600 bg-gray-100 px-3 py-0.5 text-xs font-medium tracking-wide text-blue-600">
                            New
                        </strong>

                        <div class="flex justify-between mt-8">
                            <div class="max-w-[35ch]">
                                <h1 class="text-2xl font-bold">
                                    {{ product.title }}
                                </h1>

                            </div>

                            <p class="text-lg font-bold">£ {{ product.price }}</p>
                        </div>

                        <details class="group relative mt-4 [&_summary::-webkit-details-marker]:hidden">
                            <summary class="block">
                                    <span v-if="!summary">
                                        {{product.description.slice(0, 200)}}
                                    </span>
                                    <span v-else>
                                    <p v-html="product.description"></p>
                                    </span>
                                    <a @click="summary = !summary"
                                       class="mt-4 text-sm font-medium underline cursor-pointer group-open:absolute group-open:bottom-0 group-open:left-0 group-open:mt-0">
                                        Read less</a>
                            </summary>
                        </details>
                        <div class="mt-8">
                            <button @click="store.addToCart(product, route('cart.add', product))"
                                class="btn-primary py-4 text-lg flex justify-center min-w-0 w-full mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</template>
