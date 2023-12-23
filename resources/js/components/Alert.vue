<template>
  <div v-if="message" :class="alertClasses">
    <p class="font-semibold">{{ message }}</p>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      required: true,
    },
    success: {
      type: Boolean,
      default: false,
    },
    error: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    alertClasses() {
      return {
        'bg-green-100 border-green-500 text-green-700': this.success,
        'bg-red-100 border-red-500 text-red-700': this.error,
        'p-4 mb-4 rounded': true,
      };
    },
  },
};
</script>