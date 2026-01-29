<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import Button from '../../components/Button.vue'
import AppTable from '../../components/ui/AppTable.vue'
import ModalForm from '../../components/modals/ModalForm.vue'
import DeleteConfirmModal from '../../components/modals/ModalConfirmDeletion.vue'
import { router } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'
const toast = useToast()

interface User {
    id: number;
    name: string;
    email: string;
    roles: string;
    created_at: string;
    status: string;
}

interface Props {
    users: User[];
    roles: string[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User Management',
    },
];

const tableColumns = [
    { key: 'name', label: 'Name' },
    { key: 'email', label: 'Email' },
    { key: 'roles', label: 'Roles' },
    { key: 'status', label: 'Status' },
    { key: 'created_at', label: 'Created At' },
    { key: 'actions', label: 'Actions' },
];

const showCreateModal = ref(false);
const showDeleteModal = ref(false);
const editingUser = ref<User | null>(null);
const deletingUser = ref<User | null>(null);
const formLoading = ref(false);

const formData = ref({
    name: '',
    email: '',
    password: '',
    role: '',
});

const formErrors = ref({
    name: '',
    email: '',
    password: '',
    role: '',
});

const validateForm = () => {
    let isValid = true;
    formErrors.value = {
        name: '',
        email: '',
        password: '',
        role: '',
    };

    if (!formData.value.name.trim()) {
        formErrors.value.name = 'Name is required';
        isValid = false;
    }

    if (!formData.value.email.trim()) {
        formErrors.value.email = 'Email is required';
        isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.value.email)) {
        formErrors.value.email = 'Please enter a valid email';
        isValid = false;
    }

    if (!editingUser.value && !formData.value.password.trim()) {
        formErrors.value.password = 'Password is required';
        isValid = false;
    } else if (formData.value.password && formData.value.password.length < 8) {
        formErrors.value.password = 'Password must be at least 8 characters';
        isValid = false;
    }

    // Add role validation
    if (!formData.value.role.trim()) {
        formErrors.value.role = 'Role is required';
        isValid = false;
    }

    return isValid;
};

const openCreate = () => {
    resetForm();
    showCreateModal.value = true;
}

const openEdit = (user: User) => {
    editingUser.value = user;
    formData.value = {
        name: user.name,
        email: user.email,
        password: '',
        role: user.roles,
    };
    showCreateModal.value = true;
};

const openDelete = (user: User) => {
    deletingUser.value = user;
    showDeleteModal.value = true;
}

const submitForm = () => {
    if (!validateForm()) {
        toast.error('Please fix the form errors');
        return;
    }

    formLoading.value = true;

    if (editingUser.value) {
        // Update existing user - HARDCODED URL
        router.put(`/superadmin/users/${editingUser.value.id}`, formData.value, {
            preserveScroll: true,
            onSuccess: () => {
                showCreateModal.value = false;
                resetForm();
                toast.success('User updated successfully');
            },
            onError: (errors: any) => {
                console.log('Update errors:', errors); // Debug
                toast.error('Failed to update user');
                if (errors.name) formErrors.value.name = errors.name;
                if (errors.email) formErrors.value.email = errors.email;
                if (errors.password) formErrors.value.password = errors.password;
                if (errors.role) formErrors.value.role = errors.role;
            },
            onFinish: () => {
                formLoading.value = false;
            }
        });
    } else {
        // Create new user - HARDCODED URL
        router.post('/superadmin/users', formData.value, {
            preserveScroll: true,
            onSuccess: () => {
                showCreateModal.value = false;
                resetForm();
                toast.success('User created successfully');
            },
            onError: (errors: any) => {
                console.log('Create errors:', errors); // Debug
                toast.error('Failed to create user');
                if (errors.name) formErrors.value.name = errors.name;
                if (errors.email) formErrors.value.email = errors.email;
                if (errors.password) formErrors.value.password = errors.password;
                if (errors.role) formErrors.value.role = errors.role;
            },
            onFinish: () => {
                formLoading.value = false;
            }
        });
    }
};

const handleDelete = () => {
    if (!deletingUser.value) return;

    // HARDCODED URL
    router.delete(`/superadmin/users/${deletingUser.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            showDeleteModal.value = false;
            deletingUser.value = null;
            toast.success('User deleted successfully');
        },
        onError: (error) => {
            console.log('Delete error:', error); // Debug
            toast.error('Failed to delete user');
        }
    });
}

const resetForm = () => {
    formData.value = {
        name: '',
        email: '',
        password: '',
        role: '',
    };
    formErrors.value = {
        name: '',
        email: '',
        password: '',
        role: '',
    };
    editingUser.value = null;
    formLoading.value = false;
};

</script>

<template>

    <Head title="User Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        User Management

        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">User Management</h1>

            <Button class="w-full sm:w-auto mt-3" @click="openCreate">
                Create New User
            </Button>

            <div class="mt-6">
                <AppTable :items="users" :columns="tableColumns">
                    <template #row="{ item }">
                        <td class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                            {{ item.name }}
                        </td>
                        <td class="px-6 py-4">{{ item.email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                {{ item.roles || 'No Role' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                {{ item.status }}
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
        <ModalForm v-model:isOpen="showCreateModal" :title="editingUser ? 'Edit User' : 'Create New User'"
            :loading="formLoading" @submit="submitForm">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-heading mb-1">
                        Name <span class="text-red-600">*</span>
                    </label>
                    <input v-model="formData.name" type="text"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                        :class="formErrors.name ? 'border-red-500' : 'border-default'" placeholder="Enter name"
                        required />
                    <p v-if="formErrors.name" class="text-red-600 text-sm mt-1">{{ formErrors.name }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-heading mb-1">
                        Email <span class="text-red-600">*</span>
                    </label>
                    <input v-model="formData.email" type="email"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                        :class="formErrors.email ? 'border-red-500' : 'border-default'" placeholder="Enter email"
                        required />
                    <p v-if="formErrors.email" class="text-red-600 text-sm mt-1">{{ formErrors.email }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-heading mb-1">
                        Password
                        <span v-if="!editingUser" class="text-red-600">*</span>
                        <span v-else class="text-gray-500 text-xs">(leave blank to keep current)</span>
                    </label>
                    <input v-model="formData.password" type="password"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                        :class="formErrors.password ? 'border-red-500' : 'border-default'" placeholder="Enter password"
                        :required="!editingUser" />
                    <p v-if="formErrors.password" class="text-red-600 text-sm mt-1">{{ formErrors.password }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-heading mb-1">
                        Role <span class="text-red-600">*</span>
                    </label>
                    <select v-model="formData.role"
                        class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
                        :class="formErrors.role ? 'border-red-500' : 'border-default'" required>
                        <option value="">Select a role</option>
                        <option v-for="role in roles" :key="role" :value="role">
                            {{ role.charAt(0).toUpperCase() + role.slice(1) }}
                        </option>
                    </select>
                    <p v-if="formErrors.role" class="text-red-600 text-sm mt-1">{{ formErrors.role }}</p>
                </div>
            </div>
        </ModalForm>

        <!-- Delete Modal -->
        <DeleteConfirmModal v-model:isOpen="showDeleteModal" title="Delete User" :itemName="deletingUser?.name || ''"
            @confirm="handleDelete" />
    </AppLayout>
</template>