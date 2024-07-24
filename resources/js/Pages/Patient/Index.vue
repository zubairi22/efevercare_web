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
import CorrectionSVG from "@/Components/Svg/CorrectionSVG.vue";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";

const {can,patients} = defineProps(['can','patients']);

const form = useForm({search: ''});
const statusForm = useForm({id: '', status: ''});

const statusUserModal = ref(false);

const statusUser = (patient) => {
    statusForm.id = patient.id;
    statusForm.status = patient.status
    statusUserModal.value = true;
};
const handleStatusUser = () => {
    statusForm.patch(route('patient.update', statusForm.id), {
        preserveScroll: true,
        onSuccess: () => {
            statusUserModal.value = false
            statusForm.reset()
        },
    });
};

const throttledSearch = throttle(() => {
    if (form.search) {
        router.get(route('patient.index'), {search: form.search}, {
            only: ['patients'],
            preserveState: true,
            preserveScroll: true,
        });
    } else {
        router.get(route('patient.index'));
    }
}, 500);

watch(() => form.search, () => {
    throttledSearch();
});
</script>

<template>
    <Head title="Pasien"/>

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pasien</h2>
        </template>

        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-end">
                            <div class="md:text-right mb-3">
                                <input
                                    id="user-search"
                                    v-model="form.search"
                                    class="inline-block w-full lg:w-80 rounded-lg border border-gray-300 bg-gray-50 p-2 pl-5 text-sm text-gray-900 focus:border-gray-500 focus:ring-gray-500"
                                    placeholder="Cari Pasien"
                                    type="search"
                                />
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full text-sm text-left whitespace-no-wrap">
                                <thead>
                                <tr>
                                    <TableHead class="rounded-tl rounded-bl">Nama</TableHead>
                                    <TableHead>Jenis Kelamin</TableHead>
                                    <TableHead>Tanggal Lahir</TableHead>
                                    <TableHead>Nomor Telpon</TableHead>
                                    <TableHead>Alamat</TableHead>
                                    <TableHead class="w-8"/>
                                    <TableHead class="rounded-tr rounded-br w-8"/>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(patient) in patients.data">
                                    <td class="px-4 py-4">{{ patient.name }}</td>
                                    <td class="px-4 py-4">{{ patient.gender }}</td>
                                    <td class="px-4 py-4">{{ patient.date_of_birth }}</td>
                                    <td class="px-4 py-4">{{ patient.phone_number }}</td>
                                    <td class="px-4 py-4">{{ patient.address }}</td>
                                    <td class="px-4 py-4">
                                        <PrimaryButton v-if="patient.status !== 'active'">{{ patient.status }}</PrimaryButton>
                                        <SuccessButton v-else>{{ patient.status }}</SuccessButton>
                                    </td>
                                    <td>
                                        <button v-if="can.includes('status patient')" @click="statusUser(patient)"
                                                class="inline-flex items-center p-2 bg-gray-800 border border-transparent hover:bg-gray-600 rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150">
                                            <svg class="w-6 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 1 0-18c1.052 0 2.062.18 3 .512M7 9.577l3.923 3.923 8.5-8.5M17 14v6m-3-3h6"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="!patients.total">
                                    <td class="px-4 py-4 text-base" colspan="2">Pasien tidak ditemukan</td>
                                </tr>
                                </tbody>
                            </table>
                            <PageNav :links="patients.links"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

    <ConfirmationModal :show="statusUserModal" @close="statusUserModal = false">
        <template #title>
            Ubah Status Pengguna
        </template>
        <template #content>
            Pengguna Terpilih akan diubah status nya, menyesuaikan pilihan dibawah
            <div class="mt-4">
                <InputLabel for="status" value="Status"/>
                <select v-model="statusForm.status"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option>registered</option>
                    <option>active</option>
                    <option>monitor</option>
                </select>
            </div>
        </template>
        <template #footer>
            <SecondaryButton @click="statusUserModal = false">
                Batal
            </SecondaryButton>
            <PrimaryButton class="ms-3" @click="handleStatusUser">
                Ubah Status
            </PrimaryButton>
        </template>
    </ConfirmationModal>
</template>
