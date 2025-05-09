<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarGroup,
    SidebarGroupContent,
    SidebarGroupLabel,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem
} from '@/components/ui/sidebar';
import { NavGroup, type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, ChevronDown, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger
} from '@/components/ui/collapsible';

const mainNavGroups: NavGroup[] = [
    {
        title: 'Dashboard',
        icon: LayoutGrid,
        items: [
            {
                title: 'Dashboard',
                href: '/dashboard',
                icon: LayoutGrid
            }
        ]
    },
    {
        title: 'Toko',
        icon: LayoutGrid,
        items: [
            {
                title: 'Transaksi',
                href: '/transactions',
                icon: LayoutGrid
            },
            {
                title: 'Produk',
                href: '/products',
                icon: LayoutGrid
            },
            {
                title: 'Kategori Produk',
                href: '/product-categories',
                icon: LayoutGrid
            }
        ]
    },
    {
        title: 'Karyawan',
        icon: LayoutGrid,
        items: [
            {
                title: 'Perusahaan',
                href: '/companies',
                icon: LayoutGrid
            },
            {
                title: 'Kategori Perusahaan',
                href: '/company-categories',
                icon: LayoutGrid
            },
            {
                title: 'Karyawan',
                href: '/employees',
                icon: LayoutGrid
            },
            {
                title: 'Shift',
                href: '/shifts',
                icon: LayoutGrid
            },
            {
                title: 'Posisi Jabatan',
                href: '/job-positions',
                icon: LayoutGrid
            }
        ]
    },
    {
        title: 'Laporan',
        icon: LayoutGrid,
        items: [
            {
                title: 'Lapor Pajak',
                href: '/report-tax',
                icon: LayoutGrid
            }
        ]
    },
    {
        title: 'Admin',
        icon: LayoutGrid,
        items: [
            {
                title: 'User',
                href: '/users',
                icon: LayoutGrid
            },
            {
                title: 'Role',
                href: '/roles',
                icon: LayoutGrid
            }

        ]
    }
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen
    }
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <Collapsible v-for="(group, index) in mainNavGroups" :key="index" defaultOpen class="group/collapsible">
                <SidebarGroup>
                    <SidebarGroupLabel asChild>
                        <CollapsibleTrigger>
                            {{ group.title }}
                            <ChevronDown class="ml-auto transition-transform group-data-[state=open]/collapsible:rotate-180" />
                        </CollapsibleTrigger>
                    </SidebarGroupLabel>
                    <CollapsibleContent>
                        <SidebarGroupContent>
                            <SidebarMenu>
                                <SidebarMenuItem v-for="item in group.items" :key="item.title">
                                    <SidebarMenuButton asChild>
                                        <a :href="item.href">
                                            <component :is="item.icon" />
                                            <span>{{ item.title }}</span>
                                        </a>
                                    </SidebarMenuButton>
                                </SidebarMenuItem>
                            </SidebarMenu>
                        </SidebarGroupContent>
                    </CollapsibleContent>
                </SidebarGroup>
            </Collapsible>
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
