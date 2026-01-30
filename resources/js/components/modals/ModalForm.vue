//resources/js/components/modals/ModalForm.vue
<template>
  <Transition name="modal-fade">
    <div
      v-if="isOpen"
      class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-6 lg:px-8"
      role="dialog"
      aria-modal="true"
      aria-labelledby="modal-title"
    >
      <!-- Backdrop -->
      <div
        class="absolute inset-0 bg-gray-950/65 backdrop-blur-sm dark:bg-black/65"
        @click="close"
      ></div>

      <!-- Modal container -->
      <div
        ref="modalRef"
        class="relative z-10 w-full rounded-2xl bg-white shadow-2xl border border-gray-200/80 dark:border-gray-800 dark:bg-gray-950 overflow-hidden"
        :class="[
          maxWidth === 'sm' && 'max-w-sm',
          maxWidth === 'md' && 'max-w-md',
          maxWidth === 'lg' && 'max-w-lg',
          maxWidth === 'xl' && 'max-w-xl',
          maxWidth === '2xl' && 'max-w-2xl',
          maxWidth === '3xl' && 'max-w-3xl',
          maxWidth === '4xl' && 'max-w-4xl',
          maxWidth === '5xl' && 'max-w-5xl',
          maxWidth === '6xl' && 'max-w-6xl',
        ]"
      >
        <!-- Header -->
        <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-gray-200/70 dark:border-gray-800/70">
          <div class="flex items-center gap-3">
            <slot name="icon" />
            <div>
              <h3 id="modal-title" class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                {{ title }}
              </h3>
              <p v-if="description" class="mt-1.5 text-sm text-gray-600 dark:text-gray-400">
                {{ description }}
              </p>
            </div>
          </div>

          <button
            class="text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600 rounded-full p-1.5 transition"
            @click="close"
            aria-label="Close modal"
          >
            ✕
          </button>
        </div>

        <!-- Scrollable content area -->
        <div
          class="overflow-y-auto"
          :class="[
            formHeight === 'auto' && 'max-h-[calc(100vh-180px)]',
            formHeight === 'sm'  && 'max-h-[45vh]',
            formHeight === 'md'  && 'max-h-[60vh]',
            formHeight === 'lg'  && 'max-h-[70vh]',
            formHeight === 'xl'  && 'max-h-[80vh]',
            formHeight === 'full' && 'max-h-[90vh]',
          ]"
        >
          <div class="px-6 py-6">
            <div
              class="mx-auto w-full"
              :class="[
                formWidth === 'xs'   && 'max-w-xs',
                formWidth === 'sm'   && 'max-w-sm',
                formWidth === 'md'   && 'max-w-md',
                formWidth === 'lg'   && 'max-w-lg',
                formWidth === 'xl'   && 'max-w-xl',
                formWidth === '2xl'  && 'max-w-2xl',
                formWidth === '3xl'  && 'max-w-3xl',
                formWidth === '4xl'  && 'max-w-4xl',
                formWidth === '5xl'  && 'max-w-5xl',
                formWidth === '6xl'  && 'max-w-6xl',
                formWidth === 'full' && 'max-w-full',
              ]"
            >
              <slot />
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div
          class="flex justify-end gap-3 px-6 py-5 bg-gray-50/80 dark:bg-gray-900/40 border-t border-gray-200/70 dark:border-gray-800/70"
        >
          <slot name="footer">
            <button
              type="button"
              class="rounded-lg border border-gray-300 dark:border-gray-700 px-5 py-2.5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-gray-900 dark:hover:text-gray-100 transition font-medium focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-600"
              @click="close"
            >
              Cancel
            </button>

            <button
              type="button"
              class="flex items-center gap-2 rounded-lg bg-blue-600 px-6 py-2.5 text-white hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 disabled:opacity-60 transition font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:ring-offset-2 dark:focus:ring-offset-gray-950"
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
// ... exactly the same script (no changes)
import { watch, onUnmounted, ref, nextTick } from 'vue'

const props = defineProps({
  isOpen: { type: Boolean, default: false },
  title: { type: String, default: 'Form' },
  description: { type: String, default: '' },
  submitLabel: { type: String, default: 'Save' },
  loading: { type: Boolean, default: false },

  maxWidth: {
    type: String,
    default: 'lg',
    validator: v => ['sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl'].includes(v)
  },

  formWidth: {
    type: String,
    default: 'md',
    validator: v => ['xs', 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', 'full'].includes(v)
  },

  formHeight: {
    type: String,
    default: 'auto',
    validator: v => ['auto', 'sm', 'md', 'lg', 'xl', 'full'].includes(v)
  },
})

const emit = defineEmits(['update:isOpen', 'close', 'submit'])

const modalRef = ref(null)

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
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
  transform: translateY(10px) scale(0.98);
}
</style>