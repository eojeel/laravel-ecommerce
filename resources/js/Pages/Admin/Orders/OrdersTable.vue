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
const orders = computed(() => store.orders);
const sortField = ref('updated_at');
const sortDirection = ref('desc');

const emit = defineEmits(['display-modal']);

onMounted(() => {
    store.getOrders();
})

function getOrders(url = null) {
    store.getOrders(
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
    store.getOrders(link.url)
}

function sortorders(field)
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
  getOrders();
}

function editorder(order)
{
    store.getOrders(order.id)
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
                    <select @change="getOrders(null)" v-model="perPage"
                        class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">

                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div>
                    <input v-model="search" @change="getOrders(null)"
                        class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 placeholder-white"
                        placeholder="Type to Search orders">
                </div>
            </div>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <TableHeader field="id" :sort-field="sortField" :sort-direction="sortDirection" @click="sortorders('id')">ID</TableHeader>
                            <TableHeader field="" :sort-field="sortField" :sort-direction="sortDirection">Customer</TableHeader>
                            <TableHeader field="status" :sort-field="sortField" :sort-direction="sortDirection">Status</TableHeader>
                            <TableHeader field="created_at" :sort-field="sortField" :sort-direction="sortDirection" @click="sortorders('created_at')">Date</TableHeader>
                            <TableHeader field="price" :sort-field="sortField" :sort-direction="sortDirection" @click="sortorders('price')">Price</TableHeader>
                            <TableHeader field="">Actions</TableHeader>
                        </tr>
                    </thead>
                    <tbody v-if="orders.loading">
                        <tr>
                            <td colspan="6">
                                <Spinner />
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr v-for="(order, index) of orders.data" class="animate-fade-in-down border-b" :style="{'animation-delay': '${index*0.0.5}s'}">
                            <td class="p-2">{{ order.id }}</td>
                            <td class="p-2">{{ order.customer.first_name }} {{ order.customer.last_name }}</td>
                            <td class="p-2">
                                <span>{{ order.status }}</span>
                            </td>
                            <td class="p-2">{{ order.created_at }}</td>
                            <td class="p-2">{{ order.total_price }}</td>
                            <td>
                                <TableMenu v-bind:order="order" @edit-order="editorder"/>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div v-if="!orders.loading" class="flex justify-between items-center mt-5">
                    <span>
                        Showing From {{ orders.from}} To {{ orders.to }}
                    </span>
                    <nav v-if="orders.total > orders.limit"
                        class="relative z-0 inline-flex justify-center rounded-md shadown-sm -space-x-pn"
                        aria-label="Pagination">
                        <a v-for="(link, i) of orders.links" :key="i" :disabled="!link.url" :href="link.url"
                            @click.prevent="getForPage($event, link)" aria-current="page"
                            class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                            :class="[
                                link.active
                                    ? 'z-10 bg-emerald-50 border-emerald-500 text-emerald-600'
                                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                i === 0 ? 'rounded-lg-md' : '',
                                i === orders.links.length - 1 ? 'rounded-r-md' : ''
                            ]" v-html="link.label"></a>
                    </nav>
                </div>
        </div>
</template>
