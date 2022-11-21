<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref } from "vue";
import Sidebar from "@/Components/Sidebar.vue";
import NavBar from "@/Components/NavBar.vue";

const sidebarStatus = ref(true);

function toggleSidebar()
{
    sidebarStatus.value = !sidebarStatus.value;
}
</script>

<template>
        <div class="min-h-screen flex bg-gray-100">
            <sidebar :class="{'-ml-[200px]' : !sidebarStatus}"/>

            <div class="flex-1">
                <!-- Page Heading -->
                <NavBar @toggle-sidebar="toggleSidebar"/>
                <!-- Page Content -->
                <main class="p-6">
                    <slot />
                </main>
            </div>

        </div>
</template>
