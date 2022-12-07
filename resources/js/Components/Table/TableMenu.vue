<script setup>
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue'
import { ChevronDownIcon, Cog6ToothIcon } from '@heroicons/vue/20/solid'
import { PencilIcon, TrashIcon  } from '@heroicons/vue/24/solid';
import  { useStore }  from '../../store';

const store = useStore();

const emit = defineEmits(['edit-product']);

const {product} = defineProps({
    product: Object
});

function editProduct(product)
{
    emit('edit-product', product);
}

function deleteProduct(product)
{
    if(confirm('Are you sure you want to delete this product?'))
    {
        store.deleteProduct(product.id)
        .then(() => {
            store.getProducts();
        })
    }
}
</script>


<template>
        <Menu as="div" class="relative inline-block text-left">
            <div>
                <MenuButton>
                    <Cog6ToothIcon class="w-5 h-5 text-indigo-400"
                        aria-hidden="true" />
                </MenuButton>
            </div>

            <transition enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0">
                <MenuItems
                    class="absolute  z-10 mt-2 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="px-1 py-1">
                        <MenuItem v-slot="{ active }">
                        <button :class="[
                            active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                        ]"
                         @click="editProduct(product)"
                        >
                            <PencilIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400" aria-hidden="true" />
                            Edit
                        </button>
                        </MenuItem>
                        <MenuItem v-slot="{ active }">
                        <button :class="[
                            active ? 'bg-indigo-500 text-white' : 'text-gray-900',
                            'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                        ]"
                         @click="deleteProduct(product)"
                         >
                            <TrashIcon :active="active" class="mr-2 h-5 w-5 text-indigo-400" aria-hidden="true" />
                            Delete
                        </button>
                        </MenuItem>
                    </div>
                </MenuItems>
            </transition>
        </Menu>
</template>
