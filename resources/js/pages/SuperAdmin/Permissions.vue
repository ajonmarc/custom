<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import Button from '@/components/Button.vue';
import AppTable from '@/components/ui/AppTable.vue';
import ModalForm from '@/components/modals/ModalForm.vue';
import DeleteConfirmModal from '@/components/modals/ModalConfirmDeletion.vue';
import { useToast } from 'vue-toastification';

const toast = useToast();

interface Permission {
    id: number;
    name: string;
    guard_name: string;
    description?: string;
    created_at: string;
}

interface Props {
    permissions: {
        data: Permission[];
        from: number;
        to: number;
        total: number;
        links: any[];
    };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Permissions Management',
    },
];

const tableColumns = [
    { key: 'name', label: 'Permission Name' },
    { key: 'guard_name', label: 'Guard' },
    { key: 'description', label: 'Description' },
    { key: 'created_at', label: 'Created At' },
    { key: 'actions', label: 'Actions' },
];

const showCreateModal = ref(false);
const showDeleteModal = ref(false);
const editingPermission = ref<Permission | null>(null);
const deletingPermission = ref<Permission | null>(null);
const formLoading = ref(false);

const formData = ref({
    name: '',
    description: '',
});

const formErrors = ref({
    name: '',
    description: '',
});

const validateForm = () => {
    let isValid = true;
    formErrors.value = {
        name: '',
        description: '',
    };

    if (!formData.value.name.trim()) {
        formErrors.value.name = 'Permission name is required';
        isValid = false;
    }

    return isValid;
};

const openCreate = () => {
    resetForm();
    showCreateModal.value = true;
};

const openEdit = (permission: Permission) => {
    editingPermission.value = permission;
    formData.value = {
        name: permission.name,
        description: permission.description || '',
    };
    showCreateModal.value = true;
};

const openDelete = (permission: Permission) => {
    deletingPermission.value = permission;
    showDeleteModal.value = true;
};

const submitForm = () => {
    if (!validateForm()) {
        toast.error('Please fix the form errors');
        return;
    }

    formLoading.value = true;

    if (editingPermission.value) {
        // Update existing permission
        router.put(`/superadmin/permissions/${editingPermission.value.id}`, formData.value, {
            preserveScroll: true,
            onSuccess: () => {
                showCreateModal.value = false;
                resetForm();
                toast.success('Permission updated successfully');
            },
            onError: (errors: any) => {
                console.log('Update errors:', errors);
                toast.error('Failed to update permission');
                if (errors.name) formErrors.value.name = errors.name;
                if (errors.description) formErrors.value.description = errors.description;
            },
            onFinish: () => {
                formLoading.value = false;
            }
        });
    } else {
        // Create new permission
        router.post('/superadmin/permissions', formData.value, {
            preserveScroll: true,
            onSuccess: () => {
                showCreateModal.value = false;
                resetForm();
                toast.success('Permission created successfully');
            },
            onError: (errors: any) => {
                console.log('Create errors:', errors);
                toast.error('Failed to create permission');
                if (errors.name) formErrors.value.name = errors.name;
                if (errors.description) formErrors.value.description = errors.description;
            },
            onFinish: () => {
                formLoading.value = false;
            }
        });
    }
};

const handleDelete = () => {
    if (!deletingPermission.value) return;

    router.delete(`/superadmin/permissions/${deletingPermission.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            deletingPermission.value = null;
            toast.success('Permission deleted successfully');
        },
        onError: (error) => {
            console.log('Delete error:', error);
            toast.error('Failed to delete permission');
        }
    });
};

const resetForm = () => {
    formData.value = {
        name: '',
        description: '',
    };
    formErrors.value = {
        name: '',
        description: '',
    };
    editingPermission.value = null;
    formLoading.value = false;
};

const goToPage = (url: string) => {
    router.get(url, {}, {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <Head title="Permissions Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Permissions Management</h1>

            <div class="mt-6">
                <AppTable :items="permissions.data" :columns="tableColumns" :pagination="permissions" @paginate="goToPage">
                    <template #actions>
                        <Button @click="openCreate">
                            Create New Permission
                        </Button>
                    </template>
                    <template #row="{ item }">
                        <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ item.name }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                {{ item.guard_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">
                                {{ item.description || 'No description' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ item.created_at }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <button @click="openEdit(item)" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Edit
                                </button>
                                <button @click="openDelete(item)" class="text-red-600 hover:text-red-800 font-medium">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </template>
                </AppTable>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <ModalForm
            v-model:isOpen="showCreateModal"
            :title="editingPermission ? 'Edit Permission' : 'Create New Permission'"
            :loading="formLoading"
     max-width="5xl"
  form-width="4xl"       
  form-height="full"
            @submit="submitForm"
        >
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-heading mb-1">
                        Permission Name <span class="text-red-600">*</span>
                    </label>
                    <input
                        v-model="formData.name"
                        type="text"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                        :class="formErrors.name ? 'border-red-500' : 'border-default'"
                        placeholder="e.g., view-users, edit-posts, delete-comments"
                        required
                    />
                    <p v-if="formErrors.name" class="text-red-600 text-sm mt-1">{{ formErrors.name }}</p>
                    <p class="text-gray-500 text-xs mt-1">
                        Use kebab-case format (e.g., view-users, edit-posts)
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-heading mb-1">
                        Description
                    </label>
                    <textarea
                        v-model="formData.description"
                        rows="3"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                        :class="formErrors.description ? 'border-red-500' : 'border-default'"
                        placeholder="Brief description of what this permission allows..."
                    ></textarea>
                    <p v-if="formErrors.description" class="text-red-600 text-sm mt-1">{{ formErrors.description }}</p>
                </div>
            </div>
        </ModalForm>

        <!-- Delete Modal -->
        <DeleteConfirmModal
            v-model:isOpen="showDeleteModal"
            title="Delete Permission"
            :itemName="deletingPermission?.name || ''"
            @confirm="handleDelete"
        />
    </AppLayout>
</template>