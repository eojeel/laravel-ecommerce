<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Nav from'@/Layouts/Nav.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,

})
</script>

<template>
    <Nav canLogin="canLogin" canRegister="canRegister"/>
    <Head title="Welcome" />

Hello
</template>
