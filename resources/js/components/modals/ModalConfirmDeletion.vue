<!-- resources/js/Components/UI/ModalConfirmDeletion.vue -->
<template>
  <div
    v-if="isOpen"
    class="fixed inset-0 z-50 overflow-y-auto"
    role="dialog"
    aria-modal="true"
  >
    <div
      class="fixed inset-0 bg-black/50 backdrop-blur-sm"
      @click="close"
    ></div>

    <div class="flex min-h-full items-center justify-center p-4">
      <div
        class="relative w-full max-w-md transform rounded-base bg-neutral-primary shadow-2xl transition-all border border-red-400/30"
        :class="{ 'scale-95 opacity-0': !isOpen, 'scale-100 opacity-100': isOpen }"
      >
        <div class="px-6 pt-6 pb-4">
          <h3 class="text-lg font-semibold text-red-600">
            {{ title || 'Confirm Deletion' }}
          </h3>
          <div class="mt-3 text-sm text-body">
            <slot>
              Are you sure you want to delete <strong class="text-heading">{{ itemName || 'this item' }}</strong>?
              This action cannot be undone.
            </slot>
          </div>
        </div>

        <div class="px-6 py-4 border-t border-default flex justify-end gap-3">
          <button
            type="button"
            class="px-4 py-2 rounded-md border border-default text-body hover:bg-neutral-secondary-soft"
            @click="close"
          >
            Cancel
          </button>

          <button
            type="button"
            class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 transition flex items-center gap-2"
            :disabled="loading"
            @click="$emit('confirm')"
          >
            <span v-if="loading" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
            {{ loading ? 'Deleting...' : 'Delete' }}
          </button>
        </div>

        <button class="absolute top-4 right-5 text-body hover:text-heading" @click="close">
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
  title: { type: String, default: '' },
  itemName: { type: String, default: '' },
  loading: { type: Boolean, default: false },
})

const emit = defineEmits(['update:isOpen', 'close', 'confirm'])

const close = () => {
  emit('update:isOpen', false)
  emit('close')
}

// Lock body scroll when modal is open
watch(() => props.isOpen, (val) => {
  if (val) {
    document.body.style.overflow = 'hidden'
  } else {
    document.body.style.overflow = ''
  }
})

// Close on Escape key
const handleEscape = (e) => {
  if (e.key === 'Escape' && props.isOpen) close()
}
window.addEventListener('keydown', handleEscape)
onUnmounted(() => window.removeEventListener('keydown', handleEscape))
</script>