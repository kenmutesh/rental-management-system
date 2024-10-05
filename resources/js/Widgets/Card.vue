<template>
  <div class="w-full border-t-4 border-blue-500 rounded-lg bg-gray-200 p-4 shadow-lg mb-3">
    <div v-if="title" class="mb-2 text-lg text-gray-500 font-semibold">
      {{ title }}
    </div>
    <slot />
  </div>
</template>

<script>
export default {
  name: 'EsrCard',
  props: {
    title: {
      type: String,
      default: '',
    },
  },
};
</script>

<style scoped>
.w-full {
  width: 100%;
}
.border-t-4 {
  border-top-width: 4px;
}
.border-blue-500 {
  border-color: #4299e1; /* Adjust the color if necessary */
}
.rounded-sm {
  border-radius: 0.125rem;
}
.bg-gray-200 {
  background-color: #edf2f7; /* Adjust the color if necessary */
}
.p-4 {
  padding: 1rem;
}
.shadow-lg {
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}
.mb-4 {
  margin-bottom: 1rem;
}
.text-lg {
  font-size: 1.125rem;
}
.font-semibold {
  font-weight: 600;
}
</style>
