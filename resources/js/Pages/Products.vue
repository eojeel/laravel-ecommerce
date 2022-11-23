<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import  store  from '../store';
import { ref, computed, onMounted } from 'vue';


const perPage = ref(10)
const search = ref('');
const products = computed(() => store.state.products )


onMounted(() => {
    getProducts();
})

function getProducts() {
    store.dispatch('getProducts')
}



</script>

<template>

    <Head title="Products" />

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
                <select @change="getProducts(null)" v-model="perPage"
                    class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">

                    <option value="5">5</option>
                    <option value="10">10</option>#
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div>
                <input v-model="search" @change="getProducts(null)"
                    class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    placeholder="Type to Search Products">
            </div>
        </div>
        <template>
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
                    <tr v-for="products of products.data">
                        <td class="border-b p-2">{{ product.id }}</td>
                        <td class="border-b p-2">
                            <img class="w-16" @src="product.image" :alt="product.title">
                            </td>
                        <td class="border-b p-2 m-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">{{ product.title}}</td>
                        <td class="border-b p-2">{{ product.price }}</td>
                        <td class="border-b p-2">{{ product.updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        </template>
    </div>
</template>
