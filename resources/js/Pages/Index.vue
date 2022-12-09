<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Nav from'@/Layouts/Nav.vue';

defineProps({
    loggedIn: Boolean,
})
</script>

<template>
    <Nav :loggedIn="loggedIn"/>
    <Head title="Welcome" />

Hello
</template>
