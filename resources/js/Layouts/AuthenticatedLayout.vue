<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

// Reactive state for sidebar and navigation dropdown
const showingNavigationDropdown = ref(false);
const isSidebarOpen = ref(false);
</script>

<template>
    <div class="min-h-screen flex bg-gray-100">
        <!-- Sidebar -->
        <aside
            :class="{
                'translate-x-0': isSidebarOpen,
                '-translate-x-full': !isSidebarOpen
            }"
            class="fixed inset-y-0 left-0 w-64 bg-white shadow-md transform transition-transform duration-300 ease-in-out z-50 sm:relative sm:translate-x-0"
        >
            <div class="p-4">
                <!-- Logo -->
                <Link :href="route('dashboard')">
                    <ApplicationLogo class="h-12 w-auto mb-6 text-gray-800" />
                </Link>
                <!-- Navigation Links -->
                <div class="flex flex-col  ">
                    <NavLink class="py-4 px-6" :href="route('dashboard')" :active="route().current('dashboard')">
                        Dashboard
                    </NavLink>
                    <NavLink class="py-4 px-6" :href="route('utilities')" :active="route().current('utilities')">
                        Utilities
                    </NavLink>
                    <NavLink class="py-4 px-6"   :href="route('logout')" method="post" as="button">
                        Log Out
                    </NavLink>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile when sidebar is open -->
        <div
            v-if="isSidebarOpen"
            @click="isSidebarOpen = false"
            class="fixed inset-0 bg-black opacity-50 z-40 sm:hidden"
        ></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <nav class="border-b border-gray-200 bg-white">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between items-center">
                        <div class="flex">
                            <button
                                @click="isSidebarOpen = !isSidebarOpen"
                                class="mr-4 text-gray-500 focus:outline-none sm:hidden"
                            >
                                <svg
                                    v-if="!isSidebarOpen"
                                    class="h-6 w-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <svg
                                    v-else
                                    class="h-6 w-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>


                        </div>

                        <!-- User Menu -->
                        <div class="hidden sm:ml-6 sm:flex sm:items-center">
                            <div class="relative ml-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none"
                                            >
                                                {{ $page.props.auth.user.name }}
                                                <svg
                                                    class="ml-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')">
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-1 mt-2 mx-4">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
aside::-webkit-scrollbar {
    width: 8px;
}

aside::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
    border-radius: 4px;
}
</style>
