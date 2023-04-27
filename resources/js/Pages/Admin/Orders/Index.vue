<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Orderstable from '@/Pages/Admin/Orders/OrdersTable.vue';

const orders = computed(() => store.state.orders);

function view(p)
{

}
</script>

<template>
    <Head title="Products" />
    <AuthenticatedLayout>
        <div class="flex items-center justify-between mb-3">
            <h1 class="text-3xl font-semibold">Orders</h1>
        </div>
        <Orderstable @display-modal="view"/>
    </AuthenticatedLayout>
</template>
