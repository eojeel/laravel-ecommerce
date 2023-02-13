<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
    customer: {
        type: Object,
        required: true,
    }
})

</script>

<template>
    <DefaultLayout>

        <Head title="Success" />
        <div class="mt-32">
            <div class="px-4 sm:px-8 max-w-5xl m-auto">
                <div class="bg-emerald-500 mx-auto py-2 px-3 mb-5 text-white rounded">
                    <h1>{{ props.customer.name }}, Thank you for your order!</h1>
                </div>
                <ul class="border border-gray-200 rounded overflow-hidden shadow-md">
                    <div v-for="product in order">
                        <li
                            class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out">
                            {{ product.description }}
                            <span class="">${{ product.price.unit_amount }}</span>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    </DefaultLayout>
</template>
