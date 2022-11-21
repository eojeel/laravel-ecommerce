<script setup>
import { Bars3Icon, ArrowLeftOnRectangleIcon, UserCircleIcon } from '@heroicons/vue/24/outline';
import { ChevronDownIcon } from '@heroicons/vue/20/solid'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue';

const emit = defineEmits( ['toggle-sidebar']);
</script>
<template>
    <header class="h-14 p-3 flex justify-between items-center shadow bg-white">
        <button @click="emit('toggle-sidebar')" class="flex items-center justify-center rounded transition-colors text-gray-700 hover:bg-black/10">
            <Bars3Icon class="w-6" />
        </button>
            <Menu as="div" class="relative inline-block text-left">
                <div>
                    <MenuButton class="flex items-center text-gray-700">
                        <img src="https://randomuser.me/api/portraits/men/15.jpg" class="rounded-full w-10">
                        <div class="text-small px-2">Joe Lee</div>
                        <ChevronDownIcon class="h-5 w-5 text-violet-200 hover:text-violet-100" aria-hidden="true" />
                    </MenuButton>
                </div>

                <transition enter-active-class="transition duration-100 ease-out"
                    enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-75 ease-in"
                    leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
                    <MenuItems
                        class="absolute right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <div class="px-1 py-1">
                            <MenuItem v-slot="{ active }">
                            <button :class="[
                                active ? 'bg-violet-500 text-white' : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                            ]">
                                <UserCircleIcon :active="active" class="mr-2 h-5 w-5 text-violet-400" aria-hidden="true" />
                                Profile
                            </button>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                            <button :class="[
                                active ? 'bg-violet-500 text-white' : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                            ]">
                                <ArrowLeftOnRectangleIcon :active="active" class="mr-2 h-5 w-5 text-violet-400"
                                    aria-hidden="true" />
                                Logout
                            </button>
                            </MenuItem>
                        </div>
                    </MenuItems>
                </transition>
            </Menu>
    </header>
</template>
