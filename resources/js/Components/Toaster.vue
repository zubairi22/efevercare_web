<script setup>
import {ref, watchEffect} from 'vue';
import {usePage} from '@inertiajs/vue3';

const page = usePage();
const show = ref(true);
const style = ref('success');
const message = ref('');

watchEffect(() => {
    style.value = page.props.jetstream.flash?.bannerStyle || 'success';
    message.value = page.props.jetstream.flash?.banner || '';
    show.value = !!message.value;

    setTimeout(() => {
        show.value = false
    }, 3000)
});
</script>

<template>
    <transition
        enter-active-class="ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
        leave-active-class="ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <div v-if="show && message" :class="{ 'bg-indigo-500': style === 'success', 'bg-red-700': style === 'danger' }"
             class="fixed z-50 top-8 right-5 w-full max-w-xs p-4 rounded-lg shadow" role="alert">
            <div class="flex items-center">
        <span :class="{ 'bg-indigo-600': style === 'success', 'bg-red-600': style === 'danger' }"
              class="flex p-2 rounded-lg">
          <svg v-if="style === 'success'" class="h-5 w-5 text-white" fill="none" stroke="currentColor"
               stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round"
                  stroke-linejoin="round"/>
          </svg>
          <svg v-if="style === 'danger'" class="h-5 w-5 text-white" fill="none" stroke="currentColor"
               stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                stroke-linecap="round"
                stroke-linejoin="round"/>
          </svg>
        </span>
                <p class="ml-3 font-medium text-sm text-white truncate">
                    {{ message }}
                </p>
                <button
                    :class="{ 'hover:bg-indigo-600 focus:bg-indigo-600': style === 'success', 'hover:bg-red-600 focus:bg-red-600': style === 'danger' }"
                    aria-label="Dismiss"
                    class="ml-auto flex p-2 rounded-md focus:outline-none transition"
                    type="button"
                    @click.prevent="show = false">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </transition>
</template>
