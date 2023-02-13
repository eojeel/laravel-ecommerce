<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head } from '@inertiajs/vue3';
import axiosClient from "axios";

const props = defineProps({
    orders: {
        type: Object,
        required: true,
    },
})

function checkout(orderId)
{
    axiosClient.post('/checkout/' + orderId)
        .then(result => {
            window.location.href = result.data
        })
}

</script>

<template>
    <DefaultLayout>
        <Head title="Orders" />
        <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
            <h1 class="text-3xl font-bold mb-6">My Orders</h1>

            <div class="bg-white p-3 rounded-md shadow-md">
                <table class="table table-auto w-full">
                    <thead class="border-b-2">
                        <tr class="text-left">
                            <th>Order</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th class="w-64">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order, index) of orders" class="border-b">
                            <td>

                                <a href="/src/order-details.html" class="text-emerald-600 hover:text-emerald-500">
                                    #{{ order.id }}
                                </a>
                            </td>
                            <td>{{ order.created_at  }}</td>
                            <td>
                                <span v-if="order.status == 'cancelled'" class="bg-red-500 text-white p-1 rounded">Cancelled</span>
                                <span v-if="order.status == 'paid'" class="bg-emerald-500 text-white p-1 rounded">Paid</span>
                                <span v-if="order.status == 'processing'" class="bg-orange-300 text-white p-1 rounded">Processing</span>
                                <span v-if="order.status == 'unpaid'" class="bg-gray-500 text-white p-1 rounded">Unpaid</span>
                            </td>
                            <td>${{ order.total_price }}</td>
                            <td class="flex gap-3">
                                <div x-data="{open: false}">
                                    <button @click="open = true"
                                        class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 py-1 px-2 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Invoice
                                    </button>

                                </div>
                                <a v-if="order.status == 'unpaid' && order.payment" @click="checkout(order.id)" class="btn-primary py-1 px-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Pay
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- <nav v-if="orders.total > 0"
                        class="mt-2 relative z-0 inline-flex justify-center rounded-md shadown-sm -space-x-pn"
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
                    </nav> -->
            </div>
        </div>
    </DefaultLayout>
</template>
