<script setup lang="ts">
import {
  Dialog,
  DialogContent,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { Button } from '@/components/ui/button'

defineProps<{
  title: string
  submitLabel?: string
  loading?: boolean
}>()

defineEmits(['submit'])
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <!-- 
        Use <slot> with a fallback button.
        Parent can still override with <template #trigger> ... </template>
      -->
      <slot name="trigger">
        <Button variant="outline">Open {{ title }}</Button>
      </slot>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>{{ title }}</DialogTitle>
      </DialogHeader>

      <form @submit.prevent="$emit('submit')" class="space-y-4">
        <!-- Content fields passed from parent via default slot -->
        <slot />

        <DialogFooter class="gap-2">
          <Button type="button" variant="secondary">
            Cancel
          </Button>

          <Button type="submit" :disabled="loading">
            {{ submitLabel ?? 'Save' }}
          </Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>