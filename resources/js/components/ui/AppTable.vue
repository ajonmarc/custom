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
        class="w-full sm:w-64 px-3 py-2 rounded-md border border-input bg-background text-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
      />

      <slot name="actions" />
    </div>

    <!-- Table -->
    <div class="relative overflow-x-auto rounded-xl border border-border bg-background shadow-sm">
      <div
        v-if="loading"
        class="absolute inset-0 z-10 flex items-center justify-center bg-background/80 backdrop-blur-sm"
      >
        <span class="h-6 w-6 animate-spin rounded-full border-2 border-primary border-t-transparent"></span>
      </div>

      <table class="w-full text-sm text-left text-foreground">
        <thead class="bg-muted/40 border-b border-border text-xs uppercase tracking-wide text-muted-foreground">
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
            class="border-b border-border hover:bg-muted/50 transition-colors"
          >
            <slot name="row" :item="item" :index="index" />
          </tr>

          <tr v-if="!paginatedItems.length && !loading">
            <td :colspan="columns.length" class="px-6 py-10 text-center text-muted-foreground">
              No records found
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div v-if="pagination" class="flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-muted-foreground">
      <span>
        Showing {{ pagination.from }}–{{ pagination.to }} of {{ pagination.total }}
      </span>

      <div class="flex flex-wrap gap-1">
        <button
          v-for="link in pagination.links"
          :key="link.label"
          v-html="link.label"
          :disabled="!link.url"
          @click="link.url && $emit('paginate', link.url)"
          class="px-3 py-1.5 rounded-md border border-input hover:bg-accent hover:text-accent-foreground disabled:opacity-50 disabled:pointer-events-none transition-colors"
          :class="{ 'bg-primary text-primary-foreground hover:bg-primary/90': link.active }"
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