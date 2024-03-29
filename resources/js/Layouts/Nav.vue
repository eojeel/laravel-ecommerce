<script setup>
import { useStore } from '@/store';
import { storeToRefs } from 'pinia'
import { Link, usePage } from '@inertiajs/vue3';
import {ref, computed, watch} from "vue";
import ResponsiveNav from '@/Layouts/ResponsiveNav.vue';
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import DropdownLink from '../Components/DropdownLink.vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Toast from "@/Components/Toast.vue";

const store = useStore();
const { CartItemsCount } = storeToRefs(store);

const emit = defineEmits(['toggle-sidebar']);
const mobileMenuOpen = ref(false);

function toggleResponsieNav() {
    mobileMenuOpen.value = !mobileMenuOpen.value;
}

const props = defineProps({
    mobileMenuOpen: Boolean
})
const user = computed(() => usePage().props.user)

let count = computed(() => usePage().props.cartCount)

const cartCount = ref(count);

watch(CartItemsCount, (value) => {
    cartCount.value = value;
})



</script>

<template>
    <header class="flex justify-between bg-slate-800 shadow-md text-white">
        <div>
            <a href="/" class="block py-navbar-item pl-5">
                <ApplicationLogo class="w-5 h-5 fill-current text-gray-500" />
            </a>
        </div>
        <!-- Responsive Menu -->
        <ResponsiveNav :mobileMenuOpen="mobileMenuOpen" />
        <!--/ Responsive Menu -->
        <nav class="hidden md:block">
        </nav>
        <nav class="hidden md:block">
            <ul class="grid grid-flow-col items-center">
                <li>
                    <a :href="route('cart.index')"
                        class="relative inline-flex items-center py-navbar-item px-navbar-item hover:bg-slate-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Cart
                        <small v-if="cartCount"
                            class="absolute z-[100] top-2 -right-3 py-[2px] px-[8px] rounded-full bg-red-500">{{
                                cartCount
                            }}</small>
                    </a>
                </li>
                <li>
                    <Menu v-if="user">
                        <MenuButton
                            class="cursor-pointer flex items-center py-navbar-item px-navbar-item pr-5 hover:bg-slate-900">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                My Account
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </MenuButton>
                        <MenuItems class="absolute z-10 bg-slate-800 py-2 w-full">
                            <MenuItem>
                            <a :href="route('profile.view')" class="flex px-3 py-2 hover:bg-slate-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                My Profile
                            </a>
                            </MenuItem>
                            <MenuItem>
                            <a href="/src/watchlist.html"
                                class="flex items-center justify-between px-3 py-2 hover:bg-slate-900">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    Watchlist
                                </div>

                                <small x-show="$store.header.watchlistItems" x-transition
                                    x-text="$store.header.watchlistItems"
                                    class="py-[2px] px-[8px] rounded-full bg-red-500"></small>
                            </a>
                            </MenuItem>
                            <MenuItem>
                            <a :href="route('orders.index')"  class="flex px-3 py-2 hover:bg-slate-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                My Orders
                            </a>
                            </MenuItem>
                            <MenuItem>
                            <a href="/src/logout.html" class="flex px-3 py-2 hover:bg-slate-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    Log Out
                                </DropdownLink>
                            </a>
                            </MenuItem>
                        </MenuItems>
                    </Menu>
                </li>
                <li>
                    <Link v-if="!user" :href="route('login')"
                        class="flex items-center py-navbar-item px-navbar-item hover:bg-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login
                    </Link>
                </li>
                <li>
                    <Link v-if="!user" :href="route('register')"
                        class="inline-flex items-center text-white bg-emerald-600 py-2 px-3 rounded shadow-md hover:bg-emerald-700 active:bg-emerald-800 transition-colors mx-5">
                    Register now
                    </Link>
                </li>
            </ul>
        </nav>
        <button @click="toggleResponsieNav" class="p-4 block md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </header>
    <Toast />
</template>
