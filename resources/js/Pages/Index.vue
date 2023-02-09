<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import  { useStore }  from '@/store';
import { Head } from '@inertiajs/vue3';
import Nav from '@/Layouts/Nav.vue';
import { computed } from 'vue';

const store = useStore();

const props = defineProps({
    products: Object,
    cartItemsCount: Number
})

store.cartCount(props.cartItemsCount);

const products = computed(() => props.products);

</script>

<template>
        <DefaultLayout :cartItemsCount="cartItemsCount">
        <Head title="Welcome" />

    <!-- Product List -->
    <div class="grid gap-8 grig-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 p-5">
        <!-- Product Item -->
        <div v-for="product in products.data">
            <div
          class="border border-1 border-gray-200 rounded-md hover:border-purple-600 transition-colors bg-white">
                <a :href="route('product.view', product)" class="block overflow-hidden aspect-w-3 aspect-h-2">
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
                    <button class="btn-primary" @click="store.addToCart(product, route('cart.add', product))">
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
</DefaultLayout>

</template>
