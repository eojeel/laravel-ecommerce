<script setup>
import  { useStore }  from '@/store';
import { Head } from '@inertiajs/inertia-vue3';
import Nav from "@/Layouts/Nav.vue";
import { computed } from 'vue';

const store = useStore();

const props = defineProps({
    product: Object,
    cartItemsCount: Boolean,
});

store.cartCount(props.cartItemsCount);


const products = computed(() => props.products);

</script>

<template>

<Nav :loggedIn="loggedIn" />
<Head title="product" />

<p x-text="id"></p>

    <main class="p-5">
      <div class="container mx-auto">
        <div class="grid gap-6 grid-cols-1 lg:grid-cols-5">
          <div class="lg:col-span-3">
                    <img :src="product.image" :alt="product.title" class="w-auto max-auto max-h-full"/>
          </div>
          <div class="lg:col-span-2">
            <h1 class="text-lg font-semibold">
              {{ product.title }}
            </h1>
            <div class="text-xl font-bold mb-6">£{{ product.price }}</div>
            <div class="flex items-center justify-between mb-5">
              <label for="quantity" class="block font-bold mr-4">
                Quantity
              </label>
              <input
                type="number"
                name="quantity"
                x-ref="quantityEl"
                value="1"
                class="w-32 focus:border-purple-500 focus:outline-none rounded"
              />
            </div>
            <button
              @click="addToCart(id, $refs.quantityEl.value)"
              class="btn-primary py-4 text-lg flex justify-center min-w-0 w-full mb-6"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 mr-2"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                />
              </svg>
              Add to Cart
            </button>
            <div class="mb-6" x-data="{expanded: false}">
              <div
                x-show="expanded"
                x-collapse.min.120px
                class="text-gray-500 wysiwyg-content"
              >
              {{ product.description }}
              </div>
              <p class="text-right">
                <a
                  @click="expanded = !expanded"
                  href="javascript:void(0)"
                  class="text-purple-500 hover:text-purple-700"
                  x-text="expanded ? 'Read Less' : 'Read More'"
                ></a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </main>
</template>
