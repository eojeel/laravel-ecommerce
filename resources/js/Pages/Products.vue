<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Spinner from '@/Components/Spinner.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { ref, computed, onMounted } from 'vue';
import { useStore } from '@/store';
import { PRODUCTS_PER_PAGE } from '@/constants';
import { mapActions, mapState } from 'pinia';

const store = useStore();

const perPage = ref(PRODUCTS_PER_PAGE)
const search = ref('');
const products = computed(() => store.products);

onMounted(() => {
    store.getProducts();
})

function getProduct(url = null) {
    store.getProducts(
    url,
    search.value,
    perPage.value
)
}

function getForPage(e, link) {
    if(!link.url || link.active)
    {
        return;
    }
    store.getProducts(link.url)
}
</script>

<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div class="flex items-center justify-between mb-3">
            <h1 class="text-3xl font-semibold">Products</h1>
            <button type="submit"
                class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Add New product
            </button>
        </div>

        <div class="bg-white p-4 round-lg shadow">
            <div class="flex justify-between border-b-2 pb-3">
                <div class="flex items-center">
                    <span class="whitespace-nowrap mr-3">Per Page</span>
                    <select @change="getProduct(null)" v-model="perPage"
                        class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">

                        <option value="5">5</option>
                        <option value="10">10</option>#
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div>
                    <input v-model="search" @change="getProduct(null)"
                        class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 placeholder-white"
                        placeholder="Type to Search Products">
                </div>
            </div>
            <Spinner v-if="products.loading" />
            <template v-else>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="border-b-2 p-2 text-left">ID</th>
                            <th class="border-b-2 p-2 text-left">Image</th>
                            <th class="border-b-2 p-2 text-left">Title</th>
                            <th class="border-b-2 p-2 text-left">Price</th>
                            <th class="border-b-2 p-2 text-left">Last Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product of products.data">
                            <td class="border-b p-2">{{ product.id }}</td>
                            <td class="border-b p-2">
                                <img class="w-16" :src="product.image_url" :alt="product.title">
                            </td>
                            <td class="border-b p-2 m-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">{{
                                    product.title
                            }}</td>
                            <td class="border-b p-2">{{ product.price }}</td>
                            <td class="border-b p-2">{{ product.updated_at }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-between items-center mt-5">
                    <span>
                        Showing From {{ products.from}} To {{ products.to }}
                    </span>
                    <nav v-if="products.total > products.limit"
                        class="relative z-0 inline-flex justify-center rounded-md shadown-sm -space-x-pn"
                        aria-label="Pagination">
                        <a v-for="(link, i) of products.links" :key="i" :disabled="!link.url" :href="link.url"
                            @click.prevent="getForPage($event, link)" aria-current="page"
                            class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                            :class="[
                                link.active
                                    ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                i === 0 ? 'rounded-lg-md' : '',
                                i === products.links.length - 1 ? 'rounded-r-md' : ''
                            ]" v-html="link.label"></a>
                    </nav>
                </div>
            </template>
        </div>
    </AuthenticatedLayout>
</template>
