<script setup>
import Nav from "@/Layouts/Nav.vue";


const props = defineProps({
    cartItemsCount: Number
})
</script>

<template>
    <Nav :cartItemsCount="cartItemsCount"/>
    <div>
        <div>
            <slot />
        </div>
    </div>
</template>
