<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import  { useStore }  from '../store';

const store = useStore();
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
                {{ store.name }}
            </h2>
        </template>

        <div class="p-6 rounded bg-white">
            Dashboard
        </div>
    </AuthenticatedLayout>
</template>
