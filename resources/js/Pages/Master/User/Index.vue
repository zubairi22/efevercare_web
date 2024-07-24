<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Head, router, useForm} from '@inertiajs/vue3';
import PageNav from "@/Components/PageNav.vue";
import TableHead from "@/Components/TableHead.vue";
import {ref, watch} from "vue";
import {throttle} from "lodash";
import DeleteButton from "@/Components/DeleteButton.vue";
import EditButton from "@/Components/EditButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import Badge from "@/Components/Badge.vue";
import UserForm from "@/Pages/Master/User/UserForm.vue";

const {users, roles} = defineProps(['users', 'roles']);

const form = useForm({search: ''});
const addForm = useForm({name: '', email: '', password: '', role: ''});
const editForm = useForm({id: '', name: '', email: '', role: ''});
const deleteForm = useForm({id: ''});

const addUserModal = ref(false);
const editUserModal = ref(false);
const deleteUserModal = ref(false);

const editUser = (user) => {
    editForm.id = user.id;
    editForm.name = user.name;
    editForm.email = user.email;
    editForm.role = user.roles[0].id;
    editUserModal.value = true;
};

const deleteUser = (user) => {
    deleteForm.id = user.id;
    deleteUserModal.value = true;
};

const handleAddUser = () => {
    addForm.post(route('master.users.store'), {
        preserveScroll: true,
        onSuccess: () => addUserModal.value = false,
        onFinish: () => addForm.reset(),
    });
};

const handleEditUser = () => {
    editForm.patch(route('master.users.update', editForm.id), {
        preserveScroll: true,
        onSuccess: () => editUserModal.value = false,
        onFinish: () => editForm.reset(),
    });
};

const handleDeleteUser = () => {
    router.delete(route('master.users.destroy', deleteForm.id), {
        preserveScroll: true,
        onSuccess: () => deleteUserModal.value = false,
        onFinish: () => deleteForm.reset(),
    });
};

const throttledSearch = throttle(() => {
    if (form.search) {
        router.get(route('master.users.index'), {search: form.search}, {
            only: ['users'],
            preserveState: true,
            preserveScroll: true,
        });
    } else {
        router.get(route('master.users.index'));
    }
}, 500);

watch(() => form.search, () => {
    throttledSearch();
});
</script>

<template>
    <Head title="Pengguna"/>

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pengguna</h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex flex-col md:flex-row justify-between">
                            <div>
                                <PrimaryButton class="mb-2" @click="addUserModal = true">Tambah Pengguna</PrimaryButton>
                            </div>
                            <div class="md:text-right mb-3">
                                <input
                                    id="user-search"
                                    v-model="form.search"
                                    class="inline-block w-full lg:w-80 rounded-lg border border-gray-300 bg-gray-50 p-2 pl-5 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500"
                                    placeholder="Cari Pengguna"
                                    type="search"
                                />
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm text-left whitespace-no-wrap">
                                <thead>
                                <tr>
                                    <TableHead class="rounded-tl rounded-bl">Username</TableHead>
                                    <TableHead>Email</TableHead>
                                    <TableHead>Role</TableHead>
                                    <TableHead class="w-8"/>
                                    <TableHead class="rounded-tr rounded-br w-8"/>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(user) in users.data">
                                    <td class="px-4 py-4">{{ user.name }}</td>
                                    <td class="px-4 py-4">{{ user.email }}</td>
                                    <td class="px-4 py-4 text-nowrap">
                                        <Badge :text="user.roles[0].name"/>
                                    </td>
                                    <td>
                                        <EditButton @click="editUser(user)"/>
                                    </td>
                                    <td>
                                        <DeleteButton v-show="user.roles[0].name !== 'Super-Admin'"
                                                      @click="deleteUser(user)"/>
                                    </td>
                                </tr>
                                <tr v-if="!users.total">
                                    <td class="px-4 py-4 text-base" colspan="2">Pengguna tidak ditemukan</td>
                                </tr>
                                </tbody>
                            </table>
                            <PageNav :links="users.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

    <DialogModal :show="addUserModal" @close="addUserModal = false">
        <template #title>
            Tambah Pengguna
        </template>
        <template #content>
            <UserForm :form="addForm" :roles="roles"/>
        </template>
        <template #footer>
            <SecondaryButton @click="addUserModal = false">
                Batal
            </SecondaryButton>

            <PrimaryButton
                :class="{ 'opacity-25': addForm.processing }"
                :disabled="addForm.processing"
                class="ms-3"
                @click="handleAddUser"
            >
                Simpan
            </PrimaryButton>
        </template>
    </DialogModal>

    <DialogModal :show="editUserModal" @close="editUserModal = false">
        <template #title>
            Edit Pengguna
        </template>
        <template #content>
            <UserForm :form="editForm" :roles="roles"/>
        </template>
        <template #footer>
            <SecondaryButton @click="editUserModal = false">
                Batal
            </SecondaryButton>

            <PrimaryButton
                :class="{ 'opacity-25': editForm.processing }"
                :disabled="editForm.processing"
                class="ms-3"
                @click="handleEditUser"
            >
                Simpan
            </PrimaryButton>
        </template>
    </DialogModal>

    <ConfirmationModal :show="deleteUserModal" @close="deleteUserModal = false">
        <template #title>
            Hapus Pengguna
        </template>
        <template #content>
            Are you sure you want to delete this user? Once deleted, all of its resources and data will be permanently
            deleted.
        </template>
        <template #footer>
            <SecondaryButton @click="deleteUserModal = false">
                Batal
            </SecondaryButton>
            <DangerButton class="ms-3" @click="handleDeleteUser">
                Hapus Akun
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
