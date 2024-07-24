<template>
    <div>
        <form @submit.prevent>
            <div>
                <InputLabel for="name" value="Name"/>
                <TextInput id="name" v-model="form.name" autofocus class="mt-1 block w-full" required type="text"/>
                <InputError :message="form.errors.name" class="mt-2"/>
            </div>
            <div class="mt-4">
                <InputLabel for="email" value="Email"/>
                <TextInput id="email" v-model="form.email" class="mt-1 block w-full" required type="email"/>
                <InputError :message="form.errors.email" class="mt-2"/>
            </div>
            <div v-if="!form.id" class="mt-4">
                <InputLabel for="password" value="Password"/>
                <TextInput id="password" v-model="form.password" class="mt-1 block w-full" required type="password"/>
                <InputError :message="form.errors.password" class="mt-2"/>
            </div>
            <div class="mt-4">
                <InputLabel for="role" value="Role"/>
                <select v-model="form.role"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option disabled value="">Pilih Role</option>
                    <option v-for="role in roles" :value="role.id">{{ role.name }}</option>
                </select>
                <InputError :message="form.errors.role" class="mt-2"/>
            </div>
        </form>
    </div>
</template>

<script setup>
import {defineProps} from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

defineProps({
    form: Object,
    roles: Array,
});
</script>
