<!-- resources/js/Components/UI/ModalForm.vue -->
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
        class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"
        @click="close"
      ></div>

      <!-- Modal container -->
      <div
        ref="modalRef"
        class="relative z-10 w-full rounded-2xl bg-white shadow-2xl border border-gray-200 overflow-hidden"
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
        <div class="flex items-center justify-between px-6 pt-5 pb-4 border-b border-gray-200">
          <div class="flex items-center gap-3">
            <slot name="icon" />
            <div>
              <h3 id="modal-title" class="text-xl font-semibold text-gray-900">
                {{ title }}
              </h3>
              <p v-if="description" class="mt-1 text-sm text-gray-600">
                {{ description }}
              </p>
            </div>
          </div>

          <button
            class="text-gray-500 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400 rounded-full p-1.5 transition"
            @click="close"
            aria-label="Close modal"
          >
            ✕
          </button>
        </div>

        <!-- Scrollable content area with controlled height & width -->
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
            <!-- Form content wrapper – controls width -->
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
              <!-- Default slot = your form content -->
              <slot />
            </div>
          </div>
        </div>

        <!-- Footer -->
        <div
          class="flex justify-end gap-3 border-t border-gray-200 px-6 py-4 bg-gray-50"
        >
          <slot name="footer">
            <button
              type="button"
              class="rounded-lg border border-gray-300 px-5 py-2.5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition font-medium"
              @click="close"
            >
              Cancel
            </button>

            <button
              type="button"
              class="flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-white hover:bg-blue-700 disabled:opacity-60 transition font-medium shadow-sm"
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

  // Modal container width
  maxWidth: {
    type: String,
    default: 'lg',
    validator: v => ['sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl'].includes(v)
  },

  // Inner form content width
  formWidth: {
    type: String,
    default: 'md',
    validator: v => ['xs', 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', 'full'].includes(v)
  },

  // Inner scrollable content height
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
  transition: all 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
  transform: translateY(16px) scale(0.97);
}
</style>