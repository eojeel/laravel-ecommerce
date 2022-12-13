<script setup>
import { Head, Link, usePage } from '@inertiajs/inertia-vue3';
import Nav from '@/Layouts/Nav.vue';
import { computed } from 'vue';

const props = defineProps({
    products: Object,
    loggedIn: Boolean,
})

const products = computed(() => props.products);

function isInWatchlist(id) {
    return false;
}
</script>

<template>
    <Nav :loggedIn="loggedIn" />

    <Head title="Welcome" />

    <!-- Product List -->
    <div class="grid gap-8 grig-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 p-5">
        <!-- Product Item -->
        <div v-for="product in products.data">
            <div x-data="productItem({
            id: {{ product.id }}}},
            image: {{ product.image}},
            title: '{{ product.title }}',
            price: {{ product.price }},
          })" class="border border-1 border-gray-200 rounded-md hover:border-purple-600 transition-colors bg-white">
                <a href="/src/product.html" class="block overflow-hidden aspect-w-3 aspect-h-2">
                    <img :src="product.image" :alt="product.title"
                        class="rounded-lg hover:scale-105 hover:rotate-1 transition-transform object-cover" />
                </a>
                <div class="p-4">
                    <h3 class="text-lg">
                        <a href="/src/product.html">
                            {{ product.title }}
                        </a>
                    </h3>
                    <h5 class="font-bold">£{{ product.price }}</h5>
                </div>
                <div class="flex justify-between py-3 px-4">
                    <button @click="addToWatchlist()"
                        class="w-10 h-10 rounded-full border border-1 border-purple-600 flex items-center justify-center hover:bg-purple-600 hover:text-white active:bg-purple-800 transition-colors"
                        :class="isInWatchlist(id) ? 'bg-purple-600 text-white' : 'text-purple-600'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <button class="btn-primary" @click="addToCart(id)">
                        Add to Cart
                    </button>
                </div>
            </div>
            <!--/ Product Item -->
        </div>
    </div>
    <nav class="relative z-0 inline-flex justify-center rounded-md shadown-sm -space-x-pn p-5" aria-label="Pagination">
        <a v-for="(link, i) of products.links" :key="i" :disabled="!link.url" :href="link.url" aria-current="page"
            class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap" :class="[
                link.active
                    ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                i === 0 ? 'rounded-lg-md' : '',
                i === products.links.length - 1 ? 'rounded-r-md' : ''
            ]" v-html="link.label"></a>
    </nav>
</template>
