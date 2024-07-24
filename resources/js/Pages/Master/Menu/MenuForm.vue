<template>
    <div>
        <form @submit.prevent>
            <div>
                <InputLabel for="title" value="Title"/>
                <TextInput id="title" v-model="form.title" autofocus class="mt-1 block w-full" required type="text"/>
                <InputError :message="form.errors.title" class="mt-2"/>
            </div>
            <div class="mt-4">
                <InputLabel for="url" value="Route URL"/>
                <TextInput id="url" v-model="form.url" class="mt-1 block w-full" required type="text"/>
                <InputError :message="form.errors.url" class="mt-2"/>
            </div>
            <div class="mt-4">
                <InputLabel for="icon" value="Icon"/>
                <TextInput id="icon" v-model="form.icon" class="mt-1 block w-full" required type="text"/>
                <InputError :message="form.errors.icon" class="mt-2"/>
            </div>
            <div class="mt-4">
                <InputLabel for="sort" value="Urutan"/>
                <TextInput id="sort" v-model="form.sort" class="mt-1 block w-full" required type="text"/>
                <InputError :message="form.errors.sort" class="mt-2"/>
            </div>
            <div class="mt-4">
                <InputLabel for="parent" value="Parent"/>
                <Multiselect v-model="form.parent_id" :options="parents"/>
                <InputError :message="form.errors.parent_id" class="mt-2"/>
            </div>
            <div class="mt-4">
                <InputLabel for="permissions" value="Permissions"/>
                <p>Berikan dalam format permission + title eg.<strong>view dashboard</strong></p>
                <Multiselect v-model="form.permissions" :add-option-on="['enter']" :options="form.permissions" create-option mode="tags"
                             searchable/>
                <InputError :message="form.errors.parent_id" class="mt-2"/>
            </div>
        </form>
    </div>
</template>

<script setup>
import {defineProps} from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Multiselect from '@vueform/multiselect'

defineProps({
    form: Object,
    parents: Object,
});

</script>

<style src="@vueform/multiselect/themes/default.css"/>
