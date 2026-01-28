<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { Dialog, DialogContent, DialogFooter, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog'
import { Button } from '@/components/ui/button'

defineProps<{
  title: string
  description: string
  action: string
}>()

const form = useForm({})
</script>

<template>
  <Dialog>
    <DialogTrigger as-child>
      <Button size="sm" variant="destructive">Delete</Button>
    </DialogTrigger>

    <DialogContent>
      <DialogHeader>
        <DialogTitle>{{ title }}</DialogTitle>
        <p class="text-sm text-muted-foreground">{{ description }}</p>
      </DialogHeader>

      <DialogFooter>
        <Button variant="secondary">Cancel</Button>
        <Button
          variant="destructive"
          @click="form.delete(action)"
          :disabled="form.processing"
        >
          Confirm
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
