<template>
    <Link
        :class="{'bg-blue-100': active}"
        :href="route(url)"
        class="flex items-center w-full p-2 text-gray-900 rounded-lg hover:bg-gray-100 group transition duration-150 ease-in-out">
        <slot name="icon"/>
        <span v-if="expandSideBar" class="ms-3">{{ buttonText }}</span>
    </Link>
</template>

<script setup>
import {defineProps} from 'vue';
import {Link} from '@inertiajs/vue3';

defineProps({
    buttonText: {
        type: String,
        default: ''
    },
    url: {
        type: String,
        default: ''
    },
    expandSideBar: {
        type: Boolean,
        default: true
    },
    active: {
        type: Boolean,
        default: false
    }
});
</script>
