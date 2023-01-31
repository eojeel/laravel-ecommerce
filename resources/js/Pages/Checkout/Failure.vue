<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    'error': String,
})

</script>

<template>
    <DefaultLayout>

        <Head title="Success" />
        <div class="bg-emerald-500 mx-auto py-2 px-3 text-white rounded">
            <h1>Opppss! {{ error }} </h1>
        </div>
    </DefaultLayout>
</template>
