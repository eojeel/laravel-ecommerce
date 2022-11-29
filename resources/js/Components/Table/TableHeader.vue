<script setup>
import { ChevronDoubleUpIcon, ChevronDoubleDownIcon  } from '@heroicons/vue/24/outline';

const {field, sortField, sortDirection} = defineProps({
    field: String,
    sortField: String,
    sortDirection: String
})

const emit = defineEmits(['click']);
</script>

<template>
    <th @click="emit('click', field)" class="border-b-2 p-2 text-left cursor-pointer bg-gray-100"
    :class="field === sortField ? 'bg-blue-50' : ''">
    <div class="flex justify-between">
        <slot></slot>
        <div v-if="sortField === field" class="ml-2">
            <div v-if="sortDirection == 'asc'">
                <ChevronDoubleUpIcon />
            </div>
            <div v-else>
                <ChevronDoubleDownIcon />
            </div>
        </div>
    </div>
    </th>
</template>
