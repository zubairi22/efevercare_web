<template>
    <div>
        <form @submit.prevent>
            <div>
                <InputLabel for="name" value="Name"/>
                <TextInput id="name" v-model="form.name" autocomplete="name" autofocus class="mt-1 block w-full" required
                           type="text"/>
                <InputError :message="form.errors.name" class="mt-2"/>
            </div>
            <div class="mt-4">
                <InputLabel for="guard_name" value="Guard Name"/>
                <select v-model="form.guard_name"
                        class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option disabled value="">Pilih Guard Name</option>
                    <option selected>web</option>
                    <option>api</option>
                </select>
                <InputError :message="form.errors.guard_name" class="mt-2"/>
            </div>
            <div class="mt-4">
                <InputLabel for="permissions" value="Permissions"/>
                <Multiselect v-model="form.permissions" :options="form.id ? [...form.permissions, ...permissions] : permissions" mode="tags"
                             searchable/>
                <InputError :message="form.errors.permissions" class="mt-2"/>
            </div>
        </form>
    </div>
</template>

<script setup>
import {defineProps} from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Multiselect from "@vueform/multiselect";

defineProps({
    form: Object,
    permissions: Object,
});


</script>

<style src="@vueform/multiselect/themes/default.css"/>
