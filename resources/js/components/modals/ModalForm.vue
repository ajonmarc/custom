<script setup lang="ts">
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog'
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
    <!-- Trigger -->
    <DialogTrigger as-child>
      <slot name="trigger" />
    </DialogTrigger>

    <!-- Modal -->
    <DialogContent>
      <DialogHeader>
        <DialogTitle>{{ title }}</DialogTitle>
      </DialogHeader>

      <!-- Form Body -->
      <form @submit.prevent="$emit('submit')" class="space-y-4">
        <slot />

        <DialogFooter class="gap-2">
          <Button type="button" variant="secondary">
            Cancel
          </Button>

          <Button
            type="submit"
            :disabled="loading"
          >
            {{ submitLabel ?? 'Save' }}
          </Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
