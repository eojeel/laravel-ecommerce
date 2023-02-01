<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    orders: {
        type: Object,
        required: true,
    },
})
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
                        {{  orders.orders.data  }}
                        <tr v-for="(order, index) of orders.data" class="border-b">
                            <td>
                                {{  order }}
                                <a href="/src/order-details.html" class="text-purple-600 hover:text-purple-500">
                                    #{{ order.id }}
                                </a>
                            </td>
                            <td>May 3, 07:28PM</td>
                            <td>
                                <span class="bg-gray-500 text-white p-1 rounded">Unpaid</span>
                            </td>
                            <td>$58.25</td>
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
                                    <template x-teleport="body">
                                        <!-- Backdrop -->
                                        <div x-show="open"
                                            class="fixed flex justify-center items-center left-0 top-0 bottom-0 right-0 z-10 bg-black/80">
                                            <!-- Dialog -->
                                            <div x-show="open" x-transition @click.outside="open = false"
                                                class="w-[90%] md:w-1/2 bg-white rounded-lg">
                                                <!-- Modal Title -->
                                                <div
                                                    class="py-2 px-4 text-lg font-semibold bg-gray-100 rounded-t-lg flex items-center justify-between">
                                                    <h2>Modal Title</h2>
                                                    <button @click="open = false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <!-- Modal Body -->
                                                <div class="p-4">
                                                    Invoice Content
                                                </div>
                                                <!-- Modal Footer -->
                                                <div
                                                    class="py-2 px-4 text-lg flex justify-end font-semibold bg-gray-100 rounded-b-lg">
                                                    <button @click="open = false"
                                                        class="inline-flex items-center py-1 px-3 bg-gray-300 hover:bg-opacity-95 text-gray-800 rounded-md shadow">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <button class="btn-primary py-1 px-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    Pay
                                </button>
                            </td>
                        </tr>


                    </tbody>
                </table>

                <!---
                <span class="bg-red-500 text-white p-1 rounded">Cancelled</span>
                <span class="bg-emerald-500 text-white p-1 rounded">Paid</span>
                <span class="bg-orange-300 text-white p-1 rounded">Processing</span>
                <span class="bg-gray-500 text-white p-1 rounded">Unpaid</span>
                -->
                <nav v-if="orders.total > 0"
                        class="relative z-0 inline-flex justify-center rounded-md shadown-sm -space-x-pn"
                        aria-label="Pagination">
                        <a v-for="(link, i) of orders.links" :key="i" :disabled="!link.url" :href="link.url"
                            @click.prevent="getForPage($event, link)" aria-current="page"
                            class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                            :class="[
                                link.active
                                    ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                i === 0 ? 'rounded-lg-md' : '',
                                i === orders.links.length - 1 ? 'rounded-r-md' : ''
                            ]" v-html="link.label"></a>
                    </nav>
            </div>
        </div>
    </DefaultLayout>
</template>
