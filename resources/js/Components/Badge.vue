<template>
    <span
        :class="`bg-${color}-100 text-${color}-800 text-xs font-medium me-2 px-2.5 py-0.5 mb-2 rounded dark:bg-${color}-900 dark:text-${color}-300`">
        {{ text }}
    </span>
</template>

<script setup>
defineProps({
    text: {
        type: String,
    },
    color: {
        type: String,
        default: 'blue'
    }
})
</script>
