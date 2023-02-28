<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import Sidebar from "@/Components/Sidebar.vue";
import NavBar from "@/Components/NavBar.vue";

const sidebarStatus = ref(true);

function toggleSidebar()
{
    sidebarStatus.value = !sidebarStatus.value;
}

onMounted( () => {
    if(window.outerWidth < 768) {
        sidebarStatus.value = false;
    }
    window.addEventListener('resize', sidebarOpen)
})

onUnmounted( () => {
    window.removeEventListener('resize', sidebarOpen)
})

function sidebarOpen() {
    sidebarStatus.value = window.outerWidth > 768;
}
</script>

<template>
        <div class="min-h-screen flex bg-gray-100">
            <sidebar :class="{'-ml-[200px]' : !sidebarStatus}"/>

            <div class="flex-auto">
                <!-- Page Heading -->
                <NavBar @toggle-sidebar="toggleSidebar"/>
                <!-- Page Content -->
                <main class="p-6">
                    <slot />
                </main>
            </div>

        </div>
</template>
