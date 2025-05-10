<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { createColumnHelper } from '@tanstack/vue-table';
import { h } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/v1/admin/users',
    },
];

const columnHelper = createColumnHelper<any>();

const columns = [
    columnHelper.accessor('name', {
        header: 'Name',
        cell: ({ row }) => {
            return h('div', { class: 'flex items-center gap-2' }, [
                h('div', { class: 'h-8 w-8 rounded-full bg-gray-200' }),
                h('span', null, row.getValue('name'))
            ])
        },
    }),
    columnHelper.accessor('email', {
        header: 'Email',
        cell: ({ row }) => {
            return h('div', { class: 'lowercase' }, row.getValue('email'))
        },
    }),
    columnHelper.accessor('created_at', {
        header: 'Created At',
        cell: ({ row }) => {
            return h('div', { class: 'text-sm text-gray-500' },
                new Date(row.getValue('created_at')).toLocaleDateString()
            )
        },
    }),
    columnHelper.display({
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            return h('div', { class: 'flex gap-2' }, [
                h('button', {
                    class: 'text-sm text-blue-500 hover:text-blue-700',
                    onClick: () => {
                        router.get(`/v1/admin/users/${row.original.id}/edit`)
                    }
                }, 'Edit'),
                h('button', {
                    class: 'text-sm text-red-500 hover:text-red-700',
                    onClick: () => {
                        if (confirm('Are you sure you want to delete this user?')) {
                            router.delete(`/v1/admin/users/${row.original.id}`)
                        }
                    }
                }, 'Delete')
            ])
        },
    }),
];

const data = usePage().props.users.data;
</script>

<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <DataTable :data="data" :columns="columns" />
        </div>
    </AppLayout>
</template>
