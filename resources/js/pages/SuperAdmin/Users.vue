<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import  ModalForm  from '../../components/modals/ModalForm.vue' 
import  DeleteConfirmModal  from '../../components/DeleteConfirmModal.vue'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User Management',
    },
];
</script>

<template>
    <Head title="User Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
    User Management
    </AppLayout>
</template>
