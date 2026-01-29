<!-- resources/js/Components/UI/ModalConfirmDeletion.vue -->
<template>
  <Transition name="modal-fade">
    <div
      v-if="isOpen"
      class="fixed inset-0 z-50 flex items-center justify-center px-4"
      role="dialog"
      aria-modal="true"
    >
      <!-- Backdrop -->
      <div
        class="absolute inset-0 bg-black/60 backdrop-blur-sm"
        @click="close"
      ></div>

      <!-- Modal -->
      <div
        ref="modalRef"
        class="relative z-10 w-full max-w-md rounded-xl bg-neutral-primary shadow-2xl border border-red-500/30"
      >
        <!-- Header -->
        <div class="flex items-start gap-4 px-6 pt-6">
          <div
            class="flex h-11 w-11 items-center justify-center rounded-full bg-red-100 text-red-600"
          >
            <!-- Danger Icon -->
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v4m0 4h.01M4.93 19h14.14c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.2 16c-.77 1.33.19 3 1.73 3z"
              />
            </svg>
          </div>

          <div class="flex-1">
            <h3 class="text-lg font-semibold text-red-600">
              {{ title || 'Confirm Deletion' }}
            </h3>
            <p class="mt-2 text-sm text-body">
              <slot>
                Are you sure you want to delete
                <strong class="text-heading">
                  {{ itemName || 'this item' }}
                </strong
                >?
                <br />
                <span class="text-red-500 font-medium">
                  This action cannot be undone.
                </span>
              </slot>
            </p>
          </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex justify-end gap-3 border-t border-default px-6 py-4">
          <button
            type="button"
            class="rounded-md border border-default px-4 py-2 text-body hover:bg-neutral-secondary-soft transition"
            @click="close"
          >
            Cancel
          </button>

          <button
            type="button"
            class="flex items-center gap-2 rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700 transition disabled:opacity-60"
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

        <!-- Close Button -->
        <button
          class="absolute right-4 top-4 text-body hover:text-heading"
          @click="close"
          aria-label="Close modal"
        >
          ✕
        </button>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { watch, onUnmounted, ref, nextTick } from 'vue'

const props = defineProps({
  isOpen: Boolean,
  title: String,
  itemName: String,
  loading: Boolean,
})

const emit = defineEmits(['update:isOpen', 'close', 'confirm'])

const modalRef = ref(null)

const close = () => {
  emit('update:isOpen', false)
  emit('close')
}

/* Lock body scroll */
watch(() => props.isOpen, async (open) => {
  document.body.style.overflow = open ? 'hidden' : ''
  if (open) {
    await nextTick()
    modalRef.value?.focus?.()
  }
})

/* Escape key support */
const onEscape = (e) => {
  if (e.key === 'Escape' && props.isOpen) close()
}
window.addEventListener('keydown', onEscape)

onUnmounted(() => {
  document.body.style.overflow = ''
  window.removeEventListener('keydown', onEscape)
})
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>
