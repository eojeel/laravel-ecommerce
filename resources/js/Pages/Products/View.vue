<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import Nav from "@/Layouts/Nav.vue";
import { computed } from 'vue';

const props = defineProps({
    product: Object,
});

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


                <h4>About the item</h4>
                <ul class="list-disc pl-6">
                  <li>
                    Hero 25K sensor through a software update from G HUB, this
                    upgrade is free to all players: Our most advanced, with 1:1
                    tracking, 400-plus ips, and 100 - 25,600 max dpi sensitivity
                    plus zero smoothing, filtering, or acceleration
                  </li>
                  <li>
                    11 customizable buttons and onboard memory: Assign custom
                    commands to the buttons and save up to five ready to play
                    profiles directly to the mouse
                  </li>
                  <li>
                    Adjustable weight system: Arrange up to five removable 3.6
                    grams weights inside the mouse for personalized weight and
                    balance tuning
                  </li>
                  <li>
                    Programmable RGB Lighting and Lightsync technology:
                    Customize lighting from nearly 16.8 million colors to match
                    your team's colors, sport your own or sync colors with other
                    Logitech G gear
                  </li>
                  <li>
                    Mechanical switch button tensioning: Metal spring tensioning
                    system and pivot hinges are built into left and right gaming
                    mouse buttons for a crisp, clean click feel with rapid click
                    feedback
                  </li>
                </ul>
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
