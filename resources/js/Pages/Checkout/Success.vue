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
    <div class="bg-emerald-500 mx-auto py-2 px-3 text-white rounded">
        <h1>{{ props.customer.customer_details.name }} Thank you for your order!</h1>
    </div>
    <div v-for="product in order.data">
        <p>{{  product.description }}</p>
        <span class="text-lg font-semibold">
            $<span>{{ product.price.unit_amount }}</span>
        </span>
        </div>
    </DefaultLayout>
</template>
