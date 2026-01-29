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
}

interface Role {
    id: number;
    name: string;
    guard_name: string;
    type?: string;
    description?: string;
    permissions: Permission[];
    users_count?: number;
    created_at: string;
}

interface Props {
    roles: {
        data: Role[];
        from: number;
        to: number;
        total: number;
        links: any[];
    };
    permissions: Permission[];
    roleTypes: string[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Roles Management',
    },
];

const tableColumns = [
    { key: 'name', label: 'Role Name' },
    { key: 'type', label: 'Type' },
    { key: 'guard_name', label: 'Guard' },
    { key: 'permissions', label: 'Permissions' },
    { key: 'users_count', label: 'Users' },
    { key: 'created_at', label: 'Created At' },
    { key: 'actions', label: 'Actions' },
];

const showCreateModal = ref(false);
const showDeleteModal = ref(false);
const editingRole = ref<Role | null>(null);
const deletingRole = ref<Role | null>(null);
const formLoading = ref(false);

const formData = ref({
    name: '',
    type: '',
    description: '',
    permissions: [] as number[],
});

const formErrors = ref({
    name: '',
    type: '',
    description: '',
    permissions: '',
});

const validateForm = () => {
    let isValid = true;
    formErrors.value = {
        name: '',
        type: '',
        description: '',
        permissions: '',
    };

    if (!formData.value.name.trim()) {
        formErrors.value.name = 'Role name is required';
        isValid = false;
    }

    if (formData.value.permissions.length === 0) {
        formErrors.value.permissions = 'At least one permission is required';
        isValid = false;
    }

    return isValid;
};

const openCreate = () => {
    resetForm();
    showCreateModal.value = true;
};

const openEdit = (role: Role) => {
    editingRole.value = role;
    formData.value = {
        name: role.name,
        type: role.type || '',
        description: role.description || '',
        permissions: role.permissions.map(p => p.id),
    };
    showCreateModal.value = true;
};

const openDelete = (role: Role) => {
    deletingRole.value = role;
    showDeleteModal.value = true;
};

const togglePermission = (permissionId: number) => {
    const index = formData.value.permissions.indexOf(permissionId);
    if (index > -1) {
        formData.value.permissions.splice(index, 1);
    } else {
        formData.value.permissions.push(permissionId);
    }
};

const isPermissionSelected = (permissionId: number) => {
    return formData.value.permissions.includes(permissionId);
};

const submitForm = () => {
    if (!validateForm()) {
        toast.error('Please fix the form errors');
        return;
    }

    formLoading.value = true;

    if (editingRole.value) {
        // Update existing role
        router.put(`/superadmin/roles/${editingRole.value.id}`, formData.value, {
            preserveScroll: true,
            onSuccess: () => {
                showCreateModal.value = false;
                resetForm();
                toast.success('Role updated successfully');
            },
            onError: (errors: any) => {
                console.log('Update errors:', errors);
                toast.error('Failed to update role');
                if (errors.name) formErrors.value.name = errors.name;
                if (errors.type) formErrors.value.type = errors.type;
                if (errors.description) formErrors.value.description = errors.description;
                if (errors.permissions) formErrors.value.permissions = errors.permissions;
            },
            onFinish: () => {
                formLoading.value = false;
            }
        });
    } else {
        // Create new role
        router.post('/superadmin/roles', formData.value, {
            preserveScroll: true,
            onSuccess: () => {
                showCreateModal.value = false;
                resetForm();
                toast.success('Role created successfully');
            },
            onError: (errors: any) => {
                console.log('Create errors:', errors);
                toast.error('Failed to create role');
                if (errors.name) formErrors.value.name = errors.name;
                if (errors.type) formErrors.value.type = errors.type;
                if (errors.description) formErrors.value.description = errors.description;
                if (errors.permissions) formErrors.value.permissions = errors.permissions;
            },
            onFinish: () => {
                formLoading.value = false;
            }
        });
    }
};

const handleDelete = () => {
    if (!deletingRole.value) return;

    router.delete(`/superadmin/roles/${deletingRole.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            deletingRole.value = null;
            toast.success('Role deleted successfully');
        },
        onError: (error) => {
            console.log('Delete error:', error);
            toast.error('Failed to delete role');
        }
    });
};

const resetForm = () => {
    formData.value = {
        name: '',
        type: '',
        description: '',
        permissions: [],
    };
    formErrors.value = {
        name: '',
        type: '',
        description: '',
        permissions: '',
    };
    editingRole.value = null;
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
    <Head title="Roles Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Roles Management</h1>

            <div class="mt-6">
                <AppTable :items="roles.data" :columns="tableColumns" :pagination="roles" @paginate="goToPage">
                    <template #actions>
                        <Button @click="openCreate">
                            Create New Role
                        </Button>
                    </template>
                    <template #row="{ item }">
                        <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            <div class="flex flex-col">
                                <span>{{ item.name }}</span>
                                <span v-if="item.description" class="text-xs text-gray-500 mt-1">
                                    {{ item.description }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span 
                                v-if="item.type"
                                class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800"
                            >
                                {{ item.type }}
                            </span>
                            <span v-else class="text-gray-400 text-sm">-</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                {{ item.guard_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                <span
                                    v-for="permission in item.permissions.slice(0, 3)"
                                    :key="permission.id"
                                    class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800"
                                >
                                    {{ permission.name }}
                                </span>
                                <span
                                    v-if="item.permissions.length > 3"
                                    class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800"
                                >
                                    +{{ item.permissions.length - 3 }} more
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                {{ item.users_count || 0 }} users
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
            :title="editingRole ? 'Edit Role' : 'Create New Role'"
            :loading="formLoading"
            max-width="3xl"
            @submit="submitForm"
        >
            <!-- 2-Column Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-heading mb-1">
                            Role Name <span class="text-red-600">*</span>
                        </label>
                        <input
                            v-model="formData.name"
                            type="text"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                            :class="formErrors.name ? 'border-red-500' : 'border-default'"
                            placeholder="e.g., Admin, Editor, Viewer"
                            required
                        />
                        <p v-if="formErrors.name" class="text-red-600 text-sm mt-1">{{ formErrors.name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-heading mb-1">
                            Type
                        </label>
                        <select
                            v-model="formData.type"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                            :class="formErrors.type ? 'border-red-500' : 'border-default'"
                        >
                            <option value="">Select a type (optional)</option>
                            <option v-for="type in roleTypes" :key="type" :value="type">
                                {{ type.charAt(0).toUpperCase() + type.slice(1) }}
                            </option>
                        </select>
                        <p v-if="formErrors.type" class="text-red-600 text-sm mt-1">{{ formErrors.type }}</p>
                        <p class="text-gray-500 text-xs mt-1">
                            Optional: Categorize the role
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-heading mb-1">
                            Description
                        </label>
                        <textarea
                            v-model="formData.description"
                            rows="4"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                            :class="formErrors.description ? 'border-red-500' : 'border-default'"
                            placeholder="Brief description of this role's purpose..."
                        ></textarea>
                        <p v-if="formErrors.description" class="text-red-600 text-sm mt-1">{{ formErrors.description }}</p>
                    </div>
                </div>

                <!-- Right Column - Permissions -->
                <div>
                    <label class="block text-sm font-medium text-heading mb-2">
                        Permissions <span class="text-red-600">*</span>
                    </label>
                    <div 
                        class="border rounded-md p-4 h-[320px] overflow-y-auto"
                        :class="formErrors.permissions ? 'border-red-500' : 'border-default'"
                    >
                        <div class="space-y-2">
                            <label
                                v-for="permission in permissions"
                                :key="permission.id"
                                class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-2 rounded"
                            >
                                <input
                                    type="checkbox"
                                    :checked="isPermissionSelected(permission.id)"
                                    @change="togglePermission(permission.id)"
                                    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary"
                                />
                                <span class="text-sm text-heading">{{ permission.name }}</span>
                            </label>
                        </div>
                    </div>
                    <p v-if="formErrors.permissions" class="text-red-600 text-sm mt-1">{{ formErrors.permissions }}</p>
                    <p class="text-gray-500 text-xs mt-1">
                        Selected: {{ formData.permissions.length }} permission(s)
                    </p>
                </div>
            </div>
        </ModalForm>

        <!-- Delete Modal -->
        <DeleteConfirmModal
            v-model:isOpen="showDeleteModal"
            title="Delete Role"
            :itemName="deletingRole?.name || ''"
            @confirm="handleDelete"
        />
    </AppLayout>
</template>