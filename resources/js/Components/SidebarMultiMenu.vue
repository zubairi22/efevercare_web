<template>
    <button
        :class="{'bg-blue-100': active}"
        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100"
        @click="parentClick()">
        <slot name="icon"/>
        <span v-if="expandSideBar" class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{
                buttonText
            }}</span>
        <svg v-if="expandSideBar" :class="{'rotate-180' : open}" class="w-3 h-3 mr-2" fill="none"
             viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
            <path d="m1 1 4 4 4-4" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2"/>
        </svg>
    </button>
    <ul v-show="open" class="py-2 space-y-2">
        <li v-for="(item) in children">
            <Link
                v-if="expandSideBar"
                :class="{'bg-blue-50' : route().current(item.url)}"
                :href="route(item.url)"
                class="flex items-center w-full p-2 text-sm text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">
                <component :is="HeroIcons[item.icon]" class="h-4 w-4"/>
                <span class="ms-3">{{ item.title }}</span>
            </Link>
        </li>
    </ul>
</template>

<script setup>
import {defineProps, ref} from 'vue';
import {Link} from '@inertiajs/vue3';
import * as HeroIcons from '@heroicons/vue/24/outline'

const {active} = defineProps({
    buttonText: {
        type: String,
        default: ''
    },
    children: {
        type: Array,
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

const emit = defineEmits(['clickWhenHidden'])
const open = ref(active)

const parentClick = () => {
    open.value = !open.value;
    emit('clickWhenHidden');
};

</script>
