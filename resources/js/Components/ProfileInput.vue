<script>
export default {
  name: 'CustomInput',
  watch: {
    value: {
      handler(value) {
        if (value) {
          this.error = '';
        }
      },
    },
  },
  props: {
    label: {
      type: String,
      required: true,
    },
    value: {
      type: String,
      required: true,
    },
  },
  computed: {
    name() {
      return this.label;
    },
    placeholder() {
        return this.label;
    },
    model: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit('input', value);
      },
    },
  },
}
</script>

<template>
    {{ label }}
    <input
    :placeholder="placeholder"
    type="text"
    :name="name"
    v-model="model"
    class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full"
    />
    <p v-if="error">{{ error }}</p>
</template>
