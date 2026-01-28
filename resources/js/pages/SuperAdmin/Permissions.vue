<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Permissionssss Management',
    },
];
</script>

<template>
    <Head title="Permissions Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
    Permissions Management
    </AppLayout>
</template>
