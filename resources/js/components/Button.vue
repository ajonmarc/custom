<!-- resources/js/Components/Button.vue -->
<template>
  <button
    type="button"
    class="inline-flex items-center justify-center font-medium rounded text-sm px-5 py-2.5 text-center shadow-sm transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed"
    :class="[variantClasses, $attrs.class]"
    v-bind="$attrs"
  >
    <slot />
  </button>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'primary'
  }
})

const variantClasses = computed(() => {
  const map = {
    primary: 'text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:from-blue-600 hover:via-blue-700 hover:to-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800',
    secondary: 'text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700',
    danger: 'text-white bg-red-600 hover:bg-red-700 focus:ring-red-300 dark:focus:ring-red-800',
    // ← add more variants later (success, warning, outline, etc.)
  }

  return map[props.variant] || map.primary
})
</script>