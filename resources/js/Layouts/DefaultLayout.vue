<script setup>
import Nav from "@/Layouts/Nav.vue";
import Flash from "@/Components/Flash.vue";

</script>

<template>
        <Nav/>
        <flash />
        <main class="p-5">
            <slot />
        </main>
</template>
