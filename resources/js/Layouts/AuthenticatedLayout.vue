<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Sidebar from "@/Components/Sidebar.vue";

</script>

<template>
        <div class="min-h-screen flex">
            <sidebar />

            <div class="flex-1">
                <!-- Page Heading -->
                <header class="h-8 shadow bg-white" v-if="$slots.header">
                    <div class="max-w-7xl">
                        <slot name="header" />
                    </div>
                </header>
                <!-- Page Content -->
                <main class="p-6">
                    <slot />
                </main>
            </div>

        </div>
</template>
