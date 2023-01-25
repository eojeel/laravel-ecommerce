<script setup>
import Nav from "@/Layouts/Nav.vue";
import Flash from "@/Components/Flash.vue";


const props = defineProps({
    cartItemsCount: Number
})
</script>

<template>
    <Nav :cartItemsCount="cartItemsCount"/>
    <div>
        <flash />
        <div>
            <slot />
        </div>
    </div>
</template>
