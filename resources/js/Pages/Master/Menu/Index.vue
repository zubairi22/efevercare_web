<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Head, router, useForm} from '@inertiajs/vue3';
import PageNav from "@/Components/PageNav.vue";
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
import MenuForm from "@/Pages/Master/Menu/MenuForm.vue";

const {menus, parents} = defineProps(['menus', 'parents']);

const form = useForm({search: ''});
const addForm = useForm({title: '', url: '', parent_id: '', sort: '', icon: '', permissions: []});
const editForm = useForm({id: '', title: '', url: '', parent_id: '', sort: '', icon: '', permissions: []});
const deleteForm = useForm({id: ''});

const addMenuModal = ref(false);
const editMenuModal = ref(false);
const deleteMenuModal = ref(false);

const editMenu = (menu) => {
    editForm.id = menu.id;
    editForm.title = menu.title;
    editForm.url = menu.url;
    editForm.parent_id = menu.parent_id;
    editForm.sort = menu.sort.toString();
    editForm.icon = menu.icon;
    editForm.permissions = menu.permissions.map(permission => permission.name);
    editMenuModal.value = true;
};

const deleteMenu = (menu) => {
    deleteForm.id = menu.id;
    deleteMenuModal.value = true;
};

const handleAddMenu = () => {
    addForm.post(route('master.menus.store'), {
        preserveScroll: true,
        onSuccess: () => addMenuModal.value = false,
        onFinish: () => addForm.reset(),
    });
};

const handleEditMenu = () => {
    editForm.patch(route('master.menus.update', editForm.id), {
        preserveScroll: true,
        onSuccess: () => editMenuModal.value = false,
        onFinish: () => editForm.reset(),
    });
};

const handleDeleteUser = () => {
    router.delete(route('master.menus.destroy', deleteForm.id), {
        preserveScroll: true,
        onSuccess: () => deleteMenuModal.value = false,
        onFinish: () => deleteForm.reset(),
    });
};

</script>

<template>
    <Head title="Menu"/>

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Menu</h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 ">
                        <div class="mb-3">
                            <PrimaryButton class="px-4" @click="addMenuModal = true">Tambah Menu</PrimaryButton>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm text-left whitespace-no-wrap">
                                <thead>
                                <tr>
                                    <TableHead class="rounded-tl rounded-bl">Title</TableHead>
                                    <TableHead>Route Url</TableHead>
                                    <TableHead>Permissions</TableHead>
                                    <TableHead class="w-8"/>
                                    <TableHead class="rounded-tr rounded-br w-8"/>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(menu) in menus.data">
                                    <td class="px-4 py-4">{{ menu.title }}</td>
                                    <td class="px-4 py-4">{{ menu.url }}</td>
                                    <td class="flex flex-wrap px-4 py-4">
                                        <Badge v-for="(permission) in menu.permissions" :text="permission.name"/>
                                    </td>
                                    <td>
                                        <EditButton @click="editMenu(menu)"/>
                                    </td>
                                    <td>
                                        <DeleteButton @click="deleteMenu(menu)"/>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <PageNav :links="menus.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

    <DialogModal :show="addMenuModal" @close="addMenuModal = false">
        <template #title>
            Tambah Menu
        </template>
        <template #content>
            <MenuForm :form="addForm" :parents="parents"/>
        </template>
        <template #footer>
            <SecondaryButton @click="addMenuModal = false">
                Batal
            </SecondaryButton>

            <PrimaryButton
                :class="{ 'opacity-25': addForm.processing }"
                :disabled="addForm.processing"
                class="ms-3"
                @click="handleAddMenu"
            >
                Simpan
            </PrimaryButton>
        </template>
    </DialogModal>

    <DialogModal :show="editMenuModal" @close="editMenuModal = false">
        <template #title>
            Edit Menu
        </template>
        <template #content>
            <MenuForm :form="editForm" :parents="parents"/>
        </template>
        <template #footer>
            <SecondaryButton @click="editMenuModal = false">
                Batal
            </SecondaryButton>

            <PrimaryButton
                :class="{ 'opacity-25': editForm.processing }"
                :disabled="editForm.processing"
                class="ms-3"
                @click="handleEditMenu"
            >
                Simpan
            </PrimaryButton>
        </template>
    </DialogModal>

    <ConfirmationModal :show="deleteMenuModal" @close="deleteMenuModal = false">
        <template #title>
            Hapus Menu
        </template>
        <template #content>
            Are you sure you want to delete this menu? Once deleted, all of its resources and data will be permanently
            deleted.
        </template>
        <template #footer>
            <SecondaryButton @click="deleteMenuModal = false">
                Batal
            </SecondaryButton>
            <DangerButton class="ms-3" @click="handleDeleteUser">
                Hapus Menu
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
