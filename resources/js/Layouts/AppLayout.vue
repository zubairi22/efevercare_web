<script setup>
import {onMounted, ref} from 'vue';
import {Head, Link, router} from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Toaster from "@/Components/Toaster.vue";
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import SidebarSingleMenu from "@/Components/SidebarSingleMenu.vue";
import SidebarMultiMenu from "@/Components/SidebarMultiMenu.vue";
import * as HeroIcons from '@heroicons/vue/24/outline'

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);
const expandSideBar = ref(true)

const logout = () => {
    router.post(route('logout'));
};
const toggle = () => {
    expandSideBar.value = !expandSideBar.value
    localStorage.setItem('expandSideBar', expandSideBar.value);
}

onMounted(() => {
    const storedSidebarState = localStorage.getItem('expandSideBar');
    if (storedSidebarState !== null) {
        expandSideBar.value = JSON.parse(storedSidebarState);
    }
});
</script>

<template>
    <div>
        <Head :title="title"/>

        <Toaster/>

        <nav class="fixed z-30 w-full h-16 bg-white border-b border-gray-200">
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-start">
                        <!-- Hamburger -->
                        <div class="flex mr-6 items-center lg:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        d="M4 6h16M4 12h16M4 18h16"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                    />

                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        d="M6 18L18 6M6 6l12 12"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                    />
                                </svg>
                            </button>
                        </div>

                        <Link :href="route('dashboard')">
                            <ApplicationMark class="hidden md:block h-9 ml-0.5 w-auto"/>
                        </Link>
                    </div>
                    <div class="flex sm:items-center sm:ms-6">
                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button v-if="$page.props.jetstream.managesProfilePhotos"
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img :alt="$page.props.auth.user.name"
                                             :src="$page.props.auth.user.profile_photo_url"
                                             class="h-8 w-8 rounded-full object-cover">
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"
                                                    type="button">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ms-2 -me-0.5 h-4 w-4" fill="none"
                                                     stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19.5 8.25l-7.5 7.5-7.5-7.5" stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </span>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Profile
                                    </DropdownLink>

                                    <div class="border-t border-gray-200"/>

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Log Out
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="flex pt-16 overflow-hidden bg-gray-50">

            <aside :class="{'w-64' : expandSideBar , 'w-22' : !expandSideBar , 'hidden' : !showingNavigationDropdown}"
                   class="fixed top-0 left-0 z-20 flex-col flex-shrink-0 lg:flex h-full pt-16 font-normal duration-75 transition-width">
                <div class="relative flex flex-col flex-1 h-full pt-0 bg-white border-r border-gray-200">
                    <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
                        <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200">
                            <ul class="pb-2 space-y-2">
                                <li>
                                    <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                            @click="toggle()">
                                        <svg
                                            class="h-6 w-6"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                :class="{'hidden': expandSideBar, 'inline-flex': ! expandSideBar }"
                                                d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="3"
                                            />
                                            <path
                                                :class="{'hidden': ! expandSideBar, 'inline-flex': expandSideBar }"
                                                d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="3"
                                            />

                                        </svg>
                                    </button>
                                </li>
                                <li v-for="(menu) in $page.props.sidebarMenus">
                                    <SidebarSingleMenu
                                        v-if="menu.children.length === 0"
                                        :active="route().current(menu.url)"
                                        :buttonText="menu.title"
                                        :expandSideBar="expandSideBar"
                                        :url="menu.url">
                                        <template #icon>
                                            <component :is="HeroIcons[menu.icon]" class="h-6 w-6"/>
                                        </template>
                                    </SidebarSingleMenu>
                                    <SidebarMultiMenu
                                        v-else
                                        :active="route().current(`${menu.url}.*`)"
                                        :buttonText="menu.title"
                                        :children="menu.children"
                                        :expandSideBar="expandSideBar"
                                        @clickWhenHidden="expandSideBar = true">
                                        <template #icon>
                                            <component :is="HeroIcons[menu.icon]" class="h-6 w-6"/>
                                        </template>
                                    </SidebarMultiMenu>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </aside>

            <div id="main-content" :class="{'lg:ml-64' : expandSideBar, 'lg:ml-16' : !expandSideBar}"
                 class="relative w-full h-full overflow-y-auto bg-gray-50">
                <header v-if="$slots.header" class="bg-white shadow">
                    <div class="max-w-8xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <slot name="header"/>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="min-h-screen">
                    <slot/>
                </main>

                <p class="my-10 text-sm text-center text-gray-500">
                    &copy; 2024 Z-Studio All rights reserved.
                </p>
            </div>

        </div>
    </div>
</template>
