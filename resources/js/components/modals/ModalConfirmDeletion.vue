//resources/js/components/modals/ModalConfirmDeletion.vue
<template>
  <Transition name="modal-fade">
    <div
      v-if="isOpen"
      class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6"
      role="dialog"
      aria-modal="true"
      aria-labelledby="delete-modal-title"
    >
      <!-- Backdrop -->
      <div
        class="absolute inset-0 bg-gray-950/70 backdrop-blur-sm dark:bg-black/70"
        @click="close"
      ></div>

      <!-- Modal -->
      <div
        ref="modalRef"
        class="relative z-10 w-full max-w-md rounded-2xl bg-white shadow-2xl border border-gray-200/80 dark:border-gray-800 dark:bg-gray-950 overflow-hidden"
      >
        <!-- Header / Warning Area -->
        <div class="flex items-start gap-4 px-6 pt-6 pb-5 border-b border-gray-200/70 dark:border-gray-800/70">
          <!-- Warning Icon -->
          <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-950/60 text-red-600 dark:text-red-400">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v4m0 4h.01M4.93 19h14.14c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.2 16c-.77 1.33.19 3 1.73 3z"
              />
            </svg>
          </div>

          <div class="flex-1">
            <h3 id="delete-modal-title" class="text-xl font-semibold text-gray-900 dark:text-gray-100">
              {{ title || 'Confirm Deletion' }}
            </h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
              <slot>
                Are you sure you want to delete
                <strong class="font-medium text-gray-900 dark:text-gray-200">{{ itemName || 'this item' }}</strong
                >?
              </slot>
            </p>
            <p class="mt-2 text-sm font-medium text-red-700 dark:text-red-300">
              This action cannot be undone.
            </p>
          </div>
        </div>

        <!-- Footer / Actions -->
        <div class="flex justify-end gap-3 px-6 py-5 bg-gray-50/80 dark:bg-gray-900/40 border-t border-gray-200/70 dark:border-gray-800/70">
          <button
            type="button"
            class="rounded-lg border border-gray-300 dark:border-gray-700 px-5 py-2.5 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600"
            @click="close"
          >
            Cancel
          </button>

          <button
            type="button"
            class="flex items-center gap-2 rounded-lg bg-red-600 px-6 py-2.5 text-white font-medium hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 disabled:opacity-60 disabled:cursor-not-allowed transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-400 focus:ring-offset-2 dark:focus:ring-offset-gray-950"
            :disabled="loading"
            @click="$emit('confirm')"
          >
            <span
              v-if="loading"
              class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"
            ></span>
            {{ loading ? 'Deleting...' : 'Delete' }}
          </button>
        </div>

        <!-- Close button (top-right) -->
        <button
          class="absolute right-4 top-4 text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600 rounded-full p-1 transition"
          @click="close"
          aria-label="Close confirmation dialog"
        >
          ✕
        </button>
      </div>
    </div>
  </Transition>
</template>

<script setup lang="ts">
// ... exactly the same script (no changes)
import { watch, onUnmounted, ref, nextTick } from 'vue'

const props = defineProps<{
  isOpen: boolean
  title?: string
  itemName?: string
  loading?: boolean
}>()

const emit = defineEmits<{
  (e: 'update:isOpen', value: boolean): void
  (e: 'close'): void
  (e: 'confirm'): void
}>()

const modalRef = ref<HTMLElement | null>(null)

const close = () => {
  emit('update:isOpen', false)
  emit('close')
}

watch(() => props.isOpen, async (open) => {
  document.body.style.overflow = open ? 'hidden' : ''
  if (open) {
    await nextTick()
    modalRef.value?.focus?.()
  }
})

const handleEscape = (e: KeyboardEvent) => {
  if (e.key === 'Escape' && props.isOpen) {
    close()
  }
}

window.addEventListener('keydown', handleEscape)
onUnmounted(() => {
  document.body.style.overflow = ''
  window.removeEventListener('keydown', handleEscape)
})
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
  transform: translateY(10px) scale(0.98);
}
</style>