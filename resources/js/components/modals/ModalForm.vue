<!-- resources/js/Components/UI/ModalForm.vue -->
<template>
  <Transition name="modal-fade">
    <div
      v-if="isOpen"
      class="fixed inset-0 z-50 flex items-center justify-center px-4"
      role="dialog"
      aria-modal="true"
      aria-labelledby="modal-title"
    >
      <!-- Backdrop -->
      <div
        class="absolute inset-0 bg-black/50 backdrop-blur-sm"
        @click="close"
      ></div>

      <!-- Modal -->
      <div
        ref="modalRef"
        class="relative z-10 w-full max-w-lg rounded-xl bg-neutral-primary shadow-2xl border border-default"
      >
        <!-- Header -->
        <div class="flex items-start gap-4 px-6 pt-6 pb-4 border-b border-default">
          <!-- Optional icon slot -->
          <slot name="icon" />

          <div class="flex-1">
            <h3 id="modal-title" class="text-lg font-semibold text-heading">
              {{ title }}
            </h3>
            <p v-if="description" class="mt-1 text-sm text-body">
              {{ description }}
            </p>
          </div>

          <!-- Close -->
          <button
            class="text-body hover:text-heading"
            @click="close"
            aria-label="Close modal"
          >
            ✕
          </button>
        </div>

        <!-- Content -->
        <div class="px-6 py-5">
          <slot />
        </div>

        <!-- Footer -->
        <div
          class="flex justify-end gap-3 border-t border-default px-6 py-4"
        >
          <slot name="footer">
            <button
              type="button"
              class="rounded-md border border-default px-4 py-2 text-body hover:bg-neutral-secondary-soft transition"
              @click="close"
            >
              Cancel
            </button>

            <button
              type="button"
              class="flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-white hover:bg-primary-dark transition disabled:opacity-60"
              :disabled="loading"
              @click="$emit('submit')"
            >
              <span
                v-if="loading"
                class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"
              ></span>
              {{ loading ? 'Saving...' : submitLabel }}
            </button>
          </slot>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { watch, onUnmounted, ref, nextTick } from 'vue'

const props = defineProps({
  isOpen: { type: Boolean, default: false },
  title: { type: String, default: 'Form' },
  description: { type: String, default: '' },
  submitLabel: { type: String, default: 'Save' },
  loading: { type: Boolean, default: false },
})

const emit = defineEmits(['update:isOpen', 'close', 'submit'])

const modalRef = ref(null)

const close = () => {
  emit('update:isOpen', false)
  emit('close')
}

/* Lock scroll + focus */
watch(() => props.isOpen, async (open) => {
  document.body.style.overflow = open ? 'hidden' : ''
  if (open) {
    await nextTick()
    modalRef.value?.focus?.()
  }
})

/* Escape key */
const handleEscape = (e) => {
  if (e.key === 'Escape' && props.isOpen) close()
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
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
  transform: scale(0.95);
}
</style>
