<script setup>

import { Link } from '@inertiajs/vue3';
import { HomeIcon, UsersIcon, QueueListIcon, ChartBarIcon } from  '@heroicons/vue/24/outline';
</script>

<template>
    <!-- sidebar --->
    <div class="w-[200px] transition-all bg-emerald-700 text-white py-4 px-2">
        <Link href="/dashboard" class="flex items-center py-1 px-2 rounded hover:bg-black/30 transition-colors mb-2">
              <span class="w-5 mr-2">
                 <HomeIcon />
              </span>
            <span class="text-sm font-light">
                 Dashboard
            </span>
        </Link>

        <Link href="/dashboard/products" class="flex items-center py-1 px-2 rounded hover:bg-black/30 transition-colors mb-2">
              <span class="w-5 mr-2">
                 <UsersIcon />
              </span>
            <span class="text-sm font-light">
                 Products
            </span>
        </Link>

        <Link href="/dashboard/orders" class="flex items-center py-1 px-2 rounded hover:bg-black/30 transition-colors mb-2">
              <span class="w-5 mr-2">
                 <UsersIcon />
              </span>
            <span class="text-sm font-light">
                 Orders
            </span>
        </Link>

        <Link href="/users" class="flex items-center py-1 px-2 rounded hover:bg-black/30 transition-colors mb-2">
              <span class="w-5 mr-2">
                 <QueueListIcon />
              </span>
            <span class="text-sm font-light">
                 Users
            </span>
        </Link>

        <Link href="/reports" class="flex items-center py-1 px-2 rounded hover:bg-black/30 transition-colors mb-2">
              <span class="w-5 mr-2">
                 <ChartBarIcon />
              </span>
            <span class="text-sm font-light">
                 Reports
            </span>
        </Link>

    </div>
</template>
