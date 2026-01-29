<!-- resources/js/Components/UI/ModalForm.vue -->
<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
  >
    <!-- Overlay -->
    <div
      class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity"
      :class="{ 'opacity-0': !isOpen, 'opacity-100': isOpen }"
      @click="close"
    ></div>

    <!-- Modal panel -->
    <div class="flex min-h-full items-center justify-center p-4 text-center">
      <div
        class="relative w-full max-w-lg transform rounded-base bg-neutral-primary shadow-xl transition-all"
        :class="{
          'scale-95 opacity-0': !isOpen,
          'scale-100 opacity-100': isOpen
        }"
      >
        <!-- Header -->
        <div class="px-6 pt-6 pb-4 border-b border-default">
          <h3 id="modal-title" class="text-lg font-semibold text-heading">
            {{ title }}
          </h3>
          <p v-if="description" class="mt-1 text-sm text-body">
            {{ description }}
          </p>
        </div>

        <!-- Content / Form -->
        <div class="px-6 py-5">
          <slot name="default">
            <!-- Put your form here when using the component -->
          </slot>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-default flex justify-end gap-3">
          <button
            type="button"
            class="px-4 py-2 rounded-md border border-default text-body hover:bg-neutral-secondary-soft transition"
            @click="close"
          >
            Cancel
          </button>

          <button
            type="button"
            class="px-4 py-2 rounded-md bg-primary text-white hover:bg-primary-dark transition flex items-center gap-2"
            :disabled="loading"
            @click="$emit('submit')"
          >
            <span v-if="loading" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
            {{ loading ? 'Saving...' : submitLabel }}
          </button>
        </div>

        <!-- Close X -->
        <button
          class="absolute top-4 right-5 text-body hover:text-heading"
          @click="close"
        >
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { watch, onUnmounted } from 'vue'

const props = defineProps({
  isOpen: { type: Boolean, default: false },
  title: { type: String, default: 'Form' },
  description: { type: String, default: '' },
  submitLabel: { type: String, default: 'Save' },
  loading: { type: Boolean, default: false },
})

const emit = defineEmits(['update:isOpen', 'close', 'submit'])

const close = () => {
  emit('update:isOpen', false)
  emit('close')
}

watch(() => props.isOpen, (val) => {
  if (val) {
    document.body.style.overflow = 'hidden'
  } else {
    document.body.style.overflow = ''
  }
})

// Optional: close on Escape
const handleEscape = (e) => {
  if (e.key === 'Escape' && props.isOpen) close()
}
window.addEventListener('keydown', handleEscape)
onUnmounted(() => window.removeEventListener('keydown', handleEscape))
</script>