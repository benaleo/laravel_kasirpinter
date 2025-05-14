<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { Moon, Sun } from 'lucide-vue-next';
import { useAppearance } from '@/composables/useAppearance';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

// Initialize the appearance hook
const { appearance, updateAppearance } = useAppearance();

// Toggle between light and dark mode
const toggleAppearance = () => {
    if (appearance.value === 'dark') {
        updateAppearance('light');
    } else {
        updateAppearance('dark');
    }
};


</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AppLayout>

    <!-- Dark mode toggle button -->
    <button
        @click="toggleAppearance"
        class="fixed right-4 bottom-4 w-12 h-12 rounded-full flex justify-center items-center transition-colors shadow-md"
        :class="appearance === 'dark' ? 'bg-slate-700 hover:bg-slate-600' : 'bg-slate-200 hover:bg-slate-300'"
        title="Toggle dark mode"
    >
        <Moon v-if="appearance === 'light'" class="h-5 w-5" />
        <Sun v-else class="h-5 w-5" />
    </button>

</template>
