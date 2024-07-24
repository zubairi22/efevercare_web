<script setup>
import {Link} from '@inertiajs/vue3';
</script>

<template>
    <Link
        class="inline-flex items-center p-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150">
        <slot/>
    </Link>
</template>
