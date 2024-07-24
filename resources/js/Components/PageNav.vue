<script setup>
import {Link} from '@inertiajs/vue3';

const props = defineProps(['links']);
const label = (link) => {
    return link.replace(/Sebelumnya|Berikutnya/g, "");
}

const url = (url) => {
    return url.replace('http', "http");
}

</script>

<template>
    <nav class="text-right pt-4">
        <ul class="inline-flex items-center -space-x-px p-2">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                     v-html="label(link.label)"/>
                <Link v-else
                      :class="{ 'bg-blue-700 text-white': link.active }"
                      :href="url(link.url)" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-blue focus:border-indigo-500 focus:text-indigo-500" v-html="link.label"/>
            </template>
        </ul>
    </nav>
</template>
