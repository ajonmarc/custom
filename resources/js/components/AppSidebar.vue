<script setup lang="ts">
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { 
    LayoutGrid, 
    Users, 
    UserCheck, 
    Shield, 
    FileText, 
    FolderOpen, 
    Tag, 
    Image,
    Settings,
    FileCode,
    Database,
    Wrench,
    BarChart,
    TrendingUp,
    Activity,
    DollarSign
} from 'lucide-vue-next';

import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';

import AppLogo from './AppLogo.vue';
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

const page = usePage();
const role = computed(() => page.props.auth.user.role);

// SuperAdmin
const superAdminNav: NavItem[] = [
    { title: 'Dashboard', href: '/superadmin/dashboard', icon: LayoutGrid },
   
    { 
        title: 'User Management',
        icon: Users,
        children: [
            { title: 'Users', href: '/superadmin/users', icon: Users },
            { title: 'Roles', href: '/superadmin/roles', icon: UserCheck },
            { title: 'Permissions', href: '/superadmin/permissions', icon: Shield },
        ]
    },

    { 
        title: 'Content',
        icon: FileText,
        children: [
            { title: 'Posts', href: '/superadmin/posts', icon: FileText },
            { title: 'Categories', href: '/superadmin/categories', icon: FolderOpen },
            { title: 'Tags', href: '/superadmin/tags', icon: Tag },
            { title: 'Media Library', href: '/superadmin/media', icon: Image },
        ]
    },

    { 
        title: 'System',
        icon: Settings,
        children: [
            { title: 'Settings', href: '/superadmin/settings', icon: Settings },
            { title: 'Logs', href: '/superadmin/logs', icon: FileCode },
            { title: 'Backups', href: '/superadmin/backups', icon: Database },
            { title: 'Maintenance', href: '/superadmin/maintenance', icon: Wrench },
        ]
    },

    { 
        title: 'Reports',
        icon: BarChart,
        children: [
            { title: 'Analytics', href: '/superadmin/analytics', icon: TrendingUp },
            { title: 'User Activity', href: '/superadmin/user-activity', icon: Activity },
            { title: 'Revenue', href: '/superadmin/revenue', icon: DollarSign },
        ]
    },
];



// Admin
const adminNav: NavItem[] = [
    { title: 'Dashboard', href: '/admin/dashboard', icon: LayoutGrid },
];

// User
const userNav: NavItem[] = [
    { title: 'Dashboard', href: '/user/dashboard', icon: LayoutGrid },
];

const mainNavItems = computed<NavItem[]>(() => {
    switch (role.value) {
        case 'superadmin':
            return superAdminNav;
        case 'admin':
            return adminNav;
        case 'user':
            return userNav;
        default:
            return [];
    }
});
</script>


<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>

    <slot />
</template>

