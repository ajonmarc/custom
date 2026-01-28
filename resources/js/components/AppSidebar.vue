<script setup lang="ts">
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { LayoutGrid, Users } from 'lucide-vue-next';

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
    { title: 'Users', href: '/superadmin/users', icon: Users },
    { title: 'Roles', href: '/superadmin/roles', icon: Users },
    { title: 'Permissions', href: '/superadmin/permissions', icon: Users },
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

