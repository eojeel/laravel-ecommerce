<script setup>
defineProps(['orderstatus']);
</script>

<template>
    <span v-if="orderstatus == 'cancelled'" class="bg-red-500 text-white p-1 rounded">Cancelled</span>
    <span v-if="orderstatus == 'paid'" class="bg-emerald-500 text-white p-1 rounded">Paid</span>
    <span v-if="orderstatus == 'processing'" class="bg-orange-300 text-white p-1 rounded">Processing</span>
    <span v-if="orderstatus == 'unpaid'" class="bg-gray-500 text-white p-1 rounded">Unpaid</span>
</template>
