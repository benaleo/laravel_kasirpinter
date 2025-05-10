<script setup lang="ts">
import type {
  ColumnFiltersState,
  ExpandedState,
  SortingState,
  VisibilityState,
} from '@tanstack/vue-table'
import { cn, valueUpdater } from '@/utils.ts'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { Input } from '@/components/ui/input'
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import {
  createColumnHelper,
  getCoreRowModel,
  getExpandedRowModel,
  getFilteredRowModel,
  getPaginationRowModel,
  getSortedRowModel,
  useVueTable,
  FlexRender,
} from '@tanstack/vue-table'
import { ChevronDown, ChevronsUpDown } from 'lucide-vue-next'
import { h, ref, watch } from 'vue'

const props = defineProps<{
  data: any[]
  columns: any[]
  actions?: {
    id: string;
    label: string;
    handler: (row: any) => void;
  }[]
  keyword?: string
  searchableColumns?: string[]
}>()

const emit = defineEmits<{
  (e: 'update:keyword', value: string): void
}>()

const data = ref(props.data)

watch(() => props.data, (newData) => {
  data.value = newData
}, { deep: true })

const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})
const rowSelection = ref({})
const expanded = ref<ExpandedState>({})

const table = useVueTable({
  data,
  columns: props.columns,
  getCoreRowModel: getCoreRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  getExpandedRowModel: getExpandedRowModel(),
  onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
  onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
  onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
  onRowSelectionChange: updaterOrValue => valueUpdater(updaterOrValue, rowSelection),
  onExpandedChange: updaterOrValue => valueUpdater(updaterOrValue, expanded),
  state: {
    get rowSelection() { return rowSelection.value },
    get expanded() { return expanded.value },
  },
  manualFiltering: false,
  getFilteredRowModel: getFilteredRowModel()
})
</script>

<template>
  <div class="w-full">
    <div class="flex gap-2 items-center py-4">
      <Input
        v-if="props.searchableColumns?.length"
        class="max-w-sm"
        placeholder="Search..."
        :model-value="props.keyword"
        @update:model-value="(value) => $emit('update:keyword', value)"
      />
      <DropdownMenu v-if="table.getAllColumns().length > 0">
        <DropdownMenuTrigger as-child>
          <Button variant="outline" class="ml-auto">
            Columns <ChevronDown class="ml-2 h-4 w-4" />
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
          <DropdownMenuCheckboxItem
            v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
            :key="column.id"
            class="capitalize"
            :model-value="column.getIsVisible()"
            @update:model-value="(value) => {
              column.toggleVisibility(!!value)
            }"
          >
            {{ column.id }}
          </DropdownMenuCheckboxItem>
        </DropdownMenuContent>
      </DropdownMenu>
    </div>
    <div class="rounded-md border">
      <Table>
        <TableHeader>
          <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
            <TableHead
              v-for="header in headerGroup.headers" :key="header.id" :data-pinned="header.column.getIsPinned()"
              :class="cn(
                { 'sticky bg-background/95': header.column.getIsPinned() },
                header.column.getIsPinned() === 'left' ? 'left-0' : 'right-0',
              )"
            >
              <template v-if="!header.isPlaceholder">
                <template v-if="header.column.columnDef.header">
                  <component :is="FlexRender" :render="header.column.columnDef.header" :props="header.getContext()" />
                </template>
                <template v-else>
                  {{ header.id }}
                </template>
              </template>
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <template v-if="table.getRowModel().rows?.length">
            <template v-for="row in table.getRowModel().rows" :key="row.id">
              <TableRow :data-state="row.getIsSelected() && 'selected'">
                <TableCell
                  v-for="cell in row.getVisibleCells()" :key="cell.id" :data-pinned="cell.column.getIsPinned()"
                  :class="cn(
                    { 'sticky bg-background/95': cell.column.getIsPinned() },
                    cell.column.getIsPinned() === 'left' ? 'left-0' : 'right-0',
                  )"
                >
                  <template v-if="cell.column.columnDef.cell">
                    <component :is="FlexRender" :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                  </template>
                  <template v-else>
                    {{ cell.getValue() }}
                  </template>
                </TableCell>
              </TableRow>
              <TableRow v-if="row.getIsExpanded() && actions">
                <TableCell :colspan="row.getAllCells().length">
                  <div class="flex gap-2">
                    <template v-for="action in props.actions" :key="action.id">
                      <button
                        class="text-sm text-blue-500 hover:text-blue-700"
                        :class="action.id === 'delete' ? 'text-red-500 hover:text-red-700' : 'text-blue-500 hover:text-blue-700'"
                        @click="() => action.handler(row.original)"
                      >
                        {{ action.label }}
                      </button>
                    </template>
                  </div>
                </TableCell>
              </TableRow>
            </template>
          </template>
          <TableRow v-else>
            <TableCell
              :colspan="columns.length"
              class="h-24 text-center"
            >
              No results found.
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>

    <div class="flex items-center justify-end space-x-2 py-4">
      <div class="flex-1 text-sm text-muted-foreground">
        {{ table.getFilteredSelectedRowModel().rows.length }} of
        {{ table.getFilteredRowModel().rows.length }} row(s) selected.
      </div>
      <div class="space-x-2">
        <Button
          variant="outline"
          size="sm"
          :disabled="!table.getCanPreviousPage()"
          @click="table.previousPage()"
        >
          Previous
        </Button>
        <Button
          variant="outline"
          size="sm"
          :disabled="!table.getCanNextPage()"
          @click="table.nextPage()"
        >
          Next
        </Button>
      </div>
    </div>
  </div>
</template>
