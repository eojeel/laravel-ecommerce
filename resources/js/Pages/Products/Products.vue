<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import ProductsTable from '@/Pages/Products/ProductsTable.vue'
import ProductsModal from '@/Pages/Products/ProductsModal.vue'

const ProductModal = ref(false)

function DisplayProductModal()
{
    ProductModal.value = true;
}
</script>

<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div class="flex items-center justify-between mb-3">
            <h1 class="text-3xl font-semibold">Products</h1>
            <button type="submit"
                class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                @click="DisplayProductModal">
                Add New product
            </button>
        </div>
        <ProductsModal v-model="ProductModal" />
        <ProductsTable/>
    </AuthenticatedLayout>
</template>
