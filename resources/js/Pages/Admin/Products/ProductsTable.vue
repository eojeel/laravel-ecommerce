<script setup>
import Spinner from '@/Components/Spinner.vue';
import { ref, computed, onMounted } from 'vue';
import  TableHeader  from '@/Components/Table/TableHeader.vue'
import TableMenu from '@/Components/Table/TableMenu.vue'
import { useStore } from '@/store';
import { PRODUCTS_PER_PAGE } from '@/constants';

const store = useStore();

const perPage = ref(PRODUCTS_PER_PAGE)
const search = ref('');
const products = computed(() => store.products);
const sortField = ref('updated_at');
const sortDirection = ref('desc');

const emit = defineEmits(['display-modal']);

onMounted(() => {
    store.getProducts();
})

function getProduct(url = null) {
    store.getProducts(
    url,
    search.value,
    perPage.value,
    sortField.value,
    sortDirection.value)
}

function getForPage(e, link) {
    if(!link.url || link.active)
    {
        return;
    }
    store.getProducts(link.url)
}

function sortProducts(field)
{
    if (field === sortField.value) {
    if (sortDirection.value === 'desc') {
      sortDirection.value = 'asc'
    } else {
      sortDirection.value = 'desc'
    }
  } else {
    sortField.value = field;
    sortDirection.value = 'asc'
  }
  getProduct();
}

function editProduct(product)
{
    store.getProduct(product.id)
    .then(({data}) => {
        emit('display-modal', data);
    })
}
</script>

<template>
    <div class="bg-white p-4 round-lg shadow animate-fade-in-down">
            <div class="flex justify-between border-b-2 pb-3">
                <div class="flex items-center">
                    <span class="whitespace-nowrap mr-3">Per Page</span>
                    <select @change="getProduct(null)" v-model="perPage"
                        class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">

                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div>
                    <input v-model="search" @change="getProduct(null)"
                        class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 placeholder-white"
                        placeholder="Type to Search Products">
                </div>
            </div>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <TableHeader field="id" :sort-field="sortField" :sort-direction="sortDirection" @click="sortProducts('id')">ID</TableHeader>
                            <TableHeader field="" :sort-field="sortField" :sort-direction="sortDirection">Image</TableHeader>
                            <TableHeader field="title" :sort-field="sortField" :sort-direction="sortDirection" @click="sortProducts('title')">Title</TableHeader>
                            <TableHeader field="price" :sort-field="sortField" :sort-direction="sortDirection" @click="sortProducts('price')">Price</TableHeader>
                            <TableHeader field="updated_at" :sort-field="sortField" :sort-direction="sortDirection" @click="sortProducts('updated_at')">Last Updated At</TableHeader>
                            <TableHeader field="" :sort-field="sortField" :sort-direction="sortDirection">Actions</TableHeader>
                        </tr>
                    </thead>
                    <tbody v-if="products.loading">
                        <tr>
                            <td colspan="6">
                                <Spinner />
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr v-for="(product, index) of products.data" class="animate-fade-in-down" :style="{'animation-delay': '${index*0.0.5}s'}">
                            <td class="border-b p-2">{{ product.id }}</td>
                            <td class="border-b p-2">
                                <img class="w-16" :src="product.image_url" :alt="product.title">
                            </td>
                            <td class="border-b p-2 m-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">{{
                                    product.title
                            }}</td>
                            <td class="border-b p-2">{{ product.price }}</td>
                            <td class="border-b p-2">{{ product.updated_at }}</td>
                            <td>
                                <TableMenu v-bind:product="product" @edit-product="editProduct"/>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="!products.loading" class="flex justify-between items-center mt-5">
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
                                    ? 'z-10 bg-emerald-50 border-emerald-500 text-emerald-600'
                                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                i === 0 ? 'rounded-lg-md' : '',
                                i === products.links.length - 1 ? 'rounded-r-md' : ''
                            ]" v-html="link.label"></a>
                    </nav>
                </div>
        </div>
</template>
