<!-- resources/js/Components/UI/AppTable.vue -->
<template>
  <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
    <table class="w-full text-sm text-left rtl:text-right text-body">
      <!-- Header -->
      <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
        <tr>
          <slot name="header">
            <!-- fallback if no header slot is provided -->
            <th v-for="col in columns" :key="col.key" class="px-6 py-3 font-medium">
              {{ col.label }}
            </th>
          </slot>
        </tr>
      </thead>

      <!-- Body -->
      <tbody>
        <tr
          v-for="(item, index) in items"
          :key="(item as any).id || index"
          class="bg-neutral-primary border-b border-default last:border-b-0"
        >
          <slot name="row" :item="item" :index="index">
            <!-- default simple row rendering if no slot provided -->
            <td
              v-for="col in columns"
              :key="col.key"
              class="px-6 py-4"
              :class="{ 'font-medium text-heading whitespace-nowrap': col.key === 'name' }"
            >
              {{ (item as any)[col.key] }}
            </td>
          </slot>
        </tr>

        <tr v-if="!items?.length">
          <td :colspan="columns.length || 1" class="px-6 py-8 text-center text-muted">
            No records found
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts" generic="T">
interface Column {
  key: string;
  label: string;
}

interface Props {
  items?: T[];
  columns?: Column[];
}

withDefaults(defineProps<Props>(), {
  items: () => [],
  columns: () => [],
});

defineSlots<{
  header?: () => any;
  row?: (props: { item: T; index: number }) => any;
}>();
</script>