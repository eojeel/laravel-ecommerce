<script setup>
import { computed } from 'vue';
import DefaultLayout from '../Layouts/DefaultLayout.vue';

const props = defineProps({
    status: Number
})

const title = computed(() => {
            return {
                503: 'Service Unavailable',
                500: 'Server Error',
                404: 'Page Not Found',
                403: 'Forbidden',
            }[props.status]
        });

const description = computed(() => {
            return {
                503: 'Sorry, we are doing some maintenance. Please check back soon.',
                500: 'Whoops, something went wrong on our servers.',
                404: 'Sorry, the page you are looking for could not be found.',
                403: 'Sorry, you are forbidden from accessing this page.',
            }[props.status]
        });
</script>


<template>
    <DefaultLayout>
    <div class="flex justify-center items-center min-h-full h-full w-full min-w-full">
        <div class="text-indigo-600 text-9xl px-8 font-bold border-r pb-8">
            {{ props.status }}
        </div>
        <div class="px-8">
            <h1 class="text-5xl font-bold mb-4">{{ title }}</h1>
            <p class="text-gray-600">{{ description }}</p>
            <div>
                <button>Go Home</button>
            </div>
        </div>
    </div>
</DefaultLayout>
</template>
