<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ProductsTable from '@/Pages/Admin/Products/ProductsTable.vue'
import ProductsModal from '@/Pages/Admin/Products/ProductsModal.vue'

const EMPTY_OBJECT = {
    id: '',
    title: '',
    image: '',
    description: '',
    price: '',
    published: '',
}

const ProductModal = ref(false)
const productModel = ref({...EMPTY_OBJECT});

function DisplayProductModal()
{
    ProductModal.value = true;
}

function edit(product)
{
    productModel.value = product;
    DisplayProductModal()
}

function modalClose()
{
    ProductModal.value = {...EMPTY_OBJECT}
    ProductModal.value = false;
}
</script>

<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div class="flex items-center justify-between mb-3">
            <h1 class="text-3xl font-semibold">Products</h1>
            <button type="submit"
                class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500"
                @click="DisplayProductModal">
                Add New product
            </button>
        </div>
        <ProductsModal v-model="ProductModal" :product="productModel" @close="modalClose"/>
        <ProductsTable @display-modal="edit"/>
    </AuthenticatedLayout>
</template>
