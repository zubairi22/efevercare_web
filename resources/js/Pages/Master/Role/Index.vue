<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Head, router, useForm} from '@inertiajs/vue3';
import TableHead from "@/Components/TableHead.vue";
import {ref} from "vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import EditButton from "@/Components/EditButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import Badge from "@/Components/Badge.vue";
import RoleForm from "@/Pages/Master/Role/RoleForm.vue";

const {roles, permissions} = defineProps(['roles', 'permissions']);

const addForm = useForm({name: '', guard_name: 'web', permissions: []});
const editForm = useForm({name: '', guard_name: '', permissions: []});
const deleteForm = useForm({id: ''});

const addRoleModal = ref(false);
const editRoleModal = ref(false);
const deleteRoleModal = ref(false);

const editRole = (role) => {
    editForm.id = role.id;
    editForm.name = role.name;
    editForm.guard_name = role.guard_name;
    editForm.permissions = role.permissions.map(permission => permission.name);
    editRoleModal.value = true;
};

const deleteRole = (role) => {
    deleteForm.id = role.id;
    deleteRoleModal.value = true;
};

const handleAddRole = () => {
    addForm.post(route('master.roles.store'), {
        preserveScroll: true,
        onSuccess: () => {
            addRoleModal.value = false
            addForm.reset()
        },
    });
};

const handleEditRole = () => {
    editForm.patch(route('master.roles.update', editForm.id), {
        preserveScroll: true,
        onSuccess: () => {
            editRoleModal.value = false
            editForm.reset()
        },
    });
};

const handleDeleteRole = () => {
    router.delete(route('master.roles.destroy', deleteForm.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteRoleModal.value = false
            deleteForm.reset()
        },
    });
};

</script>

<template>
    <Head title="Role"/>

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Role</h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 ">
                        <div class="mb-3">
                            <PrimaryButton class="px-4" @click="addRoleModal = true">Tambah Role</PrimaryButton>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm text-left whitespace-no-wrap">
                                <thead>
                                <tr>
                                    <TableHead class="rounded-tl rounded-bl">Name</TableHead>
                                    <TableHead>Guard Name</TableHead>
                                    <TableHead class="w-4/6">Permissions</TableHead>
                                    <TableHead class="w-8"/>
                                    <TableHead class="rounded-tr rounded-br w-8"/>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(role) in roles">
                                    <td class="px-4 py-4">{{ role.name }}</td>
                                    <td class="px-4 py-4">{{ role.guard_name }}</td>
                                    <td class="flex flex-wrap px-4 py-4 ">
                                        <Badge v-for="(permission) in role.permissions" :text="permission.name"/>
                                    </td>
                                    <td>
                                        <EditButton @click="editRole(role)"/>
                                    </td>
                                    <td>
                                        <DeleteButton @click="deleteRole(role)"/>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

    <DialogModal :show="addRoleModal" @close="addRoleModal = false">
        <template #title>
            Tambah Role
        </template>
        <template #content>
            <RoleForm :form="addForm" :permissions="permissions"/>
        </template>
        <template #footer>
            <SecondaryButton @click="addRoleModal = false">
                Batal
            </SecondaryButton>

            <PrimaryButton
                :class="{ 'opacity-25': addForm.processing }"
                :disabled="addForm.processing"
                class="ms-3"
                @click="handleAddRole"
            >
                Simpan
            </PrimaryButton>
        </template>
    </DialogModal>

    <DialogModal :show="editRoleModal" @close="editRoleModal = false">
        <template #title>
            Edit Role
        </template>
        <template #content>
            <RoleForm :form="editForm" :permissions="permissions"/>
        </template>
        <template #footer>
            <SecondaryButton @click="editRoleModal = false">
                Batal
            </SecondaryButton>

            <PrimaryButton
                :class="{ 'opacity-25': editForm.processing }"
                :disabled="editForm.processing"
                class="ms-3"
                @click="handleEditRole"
            >
                Simpan
            </PrimaryButton>
        </template>
    </DialogModal>

    <ConfirmationModal :show="deleteRoleModal" @close="deleteRoleModal = false">
        <template #title>
            Hapus Role
        </template>
        <template #content>
            Are you sure you want to delete this role? Once deleted, all of its resources and data will be permanently
            deleted.
        </template>
        <template #footer>
            <SecondaryButton @click="deleteRoleModal = false">
                Batal
            </SecondaryButton>
            <DangerButton class="ms-3" @click="handleDeleteRole">
                Hapus Akun
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
