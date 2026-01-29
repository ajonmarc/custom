<!-- resources/js/Components/UI/AppTable.vue -->
<template>
  <div class="space-y-4">
    <!-- Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <!-- Search -->
      <input
        v-if="searchable"
        v-model="search"
        type="text"
        placeholder="Search..."
        class="w-full sm:w-64 px-3 py-2 border border-default rounded-md text-sm focus:ring-2 focus:ring-primary"
      />

      <slot name="actions" />
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto rounded-xl border border-default bg-neutral-primary shadow-sm">
      <div
        v-if="loading"
        class="absolute inset-0 z-10 flex items-center justify-center bg-neutral-primary/70 backdrop-blur-sm"
      >
        <span class="h-6 w-6 animate-spin rounded-full border-2 border-primary border-t-transparent"></span>
      </div>

      <table class="w-full text-sm text-left text-body">
        <thead class="bg-neutral-secondary-soft border-b border-default text-xs uppercase tracking-wide">
          <tr>
            <th
              v-for="col in columns"
              :key="col.key"
              class="px-6 py-3 font-medium cursor-pointer select-none"
              @click="sortable && toggleSort(col.key)"
            >
              <div class="flex items-center gap-1">
                {{ col.label }}
                <span v-if="sortBy === col.key">
                  {{ sortDir === 'asc' ? '▲' : '▼' }}
                </span>
              </div>
            </th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="(item, index) in paginatedItems"
            :key="(item as any).id ?? index"
            class="border-b border-default hover:bg-neutral-secondary-soft/60"
          >
            <slot name="row" :item="item" :index="index" />
          </tr>

          <tr v-if="!paginatedItems.length && !loading">
            <td :colspan="columns.length" class="px-6 py-10 text-center text-muted">
              No records found
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div v-if="pagination" class="flex justify-between items-center text-sm">
      <span class="text-muted">
        Showing {{ pagination.from }}–{{ pagination.to }} of {{ pagination.total }}
      </span>

      <div class="flex gap-1">
     <button
  v-for="link in pagination.links"
  :key="link.label"
  v-html="link.label"
  :disabled="!link.url"
  @click="link.url && $emit('paginate', link.url)"
  class="px-3 py-1 rounded-md border border-default hover:bg-neutral-secondary-soft disabled:opacity-50"
  :class="{ 'bg-primary text-white': link.active }"
/>

      </div>
    </div>
  </div>
</template>

<script setup lang="ts" generic="T">
import { computed, ref } from 'vue'

interface Column {
  key: string
  label: string
}

interface Pagination {
  from: number
  to: number
  total: number
  links: {
    url: string | null
    label: string
    active: boolean
  }[]
}

const props = withDefaults(defineProps<{
  items: T[]
  columns: Column[]
  pagination?: Pagination | null
  loading?: boolean
  searchable?: boolean
  sortable?: boolean
}>(), {
  loading: false,
  searchable: true,
  sortable: true,
})

const emit = defineEmits(['paginate'])

const search = ref('')
const sortBy = ref<string | null>(null)
const sortDir = ref<'asc' | 'desc'>('asc')

const filteredItems = computed(() => {
  if (!search.value) return props.items

  return props.items.filter(item =>
    JSON.stringify(item).toLowerCase().includes(search.value.toLowerCase())
  )
})

const sortedItems = computed(() => {
  if (!sortBy.value) return filteredItems.value

  return [...filteredItems.value].sort((a: any, b: any) => {
    const res = a[sortBy.value] > b[sortBy.value] ? 1 : -1
    return sortDir.value === 'asc' ? res : -res
  })
})

const paginatedItems = computed(() => {
  return sortedItems.value
})

const toggleSort = (key: string) => {
  if (sortBy.value === key) {
    sortDir.value = sortDir.value === 'asc' ? 'desc' : 'asc'
  } else {
    sortBy.value = key
    sortDir.value = 'asc'
  }
}
</script>
