<script>
export default {
    data() {
        return {
            show: true,
        }
    },
    watch: {
        '$page.props.flash.message': function() {
            this.show = true;
        },
        deep: true,
    },
}
</script>

<template>
 <div v-if="$page.props.flash.message && show" class="grid place-items-center mt-1 mb-1">
<div class="relative bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3 w-1/2 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black overflow-hidden" role="alert">
  <p class="font-bold">hey!</p>
  <p class="text-sm"> {{ $page.props.flash.message }}</p>
  <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
</svg>
</button>

  </div>
</div>
</template>
