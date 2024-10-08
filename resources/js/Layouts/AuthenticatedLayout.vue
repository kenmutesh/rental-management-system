<script setup>
import { ref } from 'vue';

// Reactive state for sidebar and navigation dropdowns
const isSidebarOpen = ref(false);
const showingChildren = ref(null); // To manage parent-child toggling
const showingSubChildren = ref(null); // To manage sub-child toggling

// Function to toggle parent items
const toggleChildren = (index) => {
    if (showingChildren.value === index) {
        showingChildren.value = null; // Close if already open
    } else {
        showingChildren.value = index; // Open the clicked one
    }
};

// Function to toggle sub-children
const toggleSubChildren = (index) => {
    if (showingSubChildren.value === index) {
        showingSubChildren.value = null;
    } else {
        showingSubChildren.value = index;
    }
};
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
                <a href="/" class="block mb-6">
                    <img src="/logo.png" alt="Logo" class="h-12 w-auto text-gray-800" />
                </a>

                <!-- Navigation Links -->
                <nav class="flex flex-col space-y-2">
                    <!-- Dashboard -->
                    <a href="/dashboard" class="block py-4 px-6 text-gray-600 hover:text-gray-900">Dashboard</a>

                    <!-- Financials -->
                    <div>
                        <button @click="toggleChildren(1)" class="flex justify-between w-full py-4 px-6 text-left">
                            <span>Financials</span>
                            <svg :class="{ 'rotate-180': showingChildren === 1 }" class="w-4 h-4 transform transition-transform duration-300">
                                <path d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div v-if="showingChildren === 1" class="pl-8 transition-all duration-300">
                            <a href="/invoices" class="block py-2 text-gray-600 hover:text-gray-900">Invoices</a>
                            <a href="/payments" class="block py-2 text-gray-600 hover:text-gray-900">Payments</a>
                            <a href="/expenses" class="block py-2 text-gray-600 hover:text-gray-900">Expenses</a>
                        </div>
                    </div>

                    <!-- Tenants -->
                    <a href="/tenants" class="block py-4 px-6 text-gray-600 hover:text-gray-900">Tenants</a>

                    <!-- Property/Unit -->
                    <div>
                        <button @click="toggleChildren(2)" class="flex justify-between w-full py-4 px-6 text-left">
                            <span>Property/Unit</span>
                            <svg :class="{ 'rotate-180': showingChildren === 2 }" class="w-4 h-4 transform transition-transform duration-300">
                                <path d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div v-if="showingChildren === 2" class="pl-8 transition-all duration-300">
                            <a href="/properties" class="block py-2 text-gray-600 hover:text-gray-900">Properties</a>
                            <a href="/units" class="block py-2 text-gray-600 hover:text-gray-900">Units</a>
                            <a href="/utilities" class="block py-2 text-gray-600 hover:text-gray-900">Utilities</a>
                            <a href="/maintenance" class="block py-2 text-gray-600 hover:text-gray-900">Maintenance</a>
                        </div>
                    </div>

                    <!-- Reports -->
                    <a href="/reports" class="block py-4 px-6 text-gray-600 hover:text-gray-900">Reports</a>

                    <!-- Communication -->
                    <a href="/communication" class="block py-4 px-6 text-gray-600 hover:text-gray-900">Communication</a>

                    <!-- Settings -->
                    <div>
                        <button @click="toggleChildren(3)" class="flex justify-between w-full py-4 px-6 text-left">
                            <span>Settings</span>
                            <svg :class="{ 'rotate-180': showingChildren === 3 }" class="w-4 h-4 transform transition-transform duration-300">
                                <path d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div v-if="showingChildren === 3" class="pl-8 transition-all duration-300">
                            <a href="/general" class="block py-2 text-gray-600 hover:text-gray-900">General</a>
                            <a href="/backup" class="block py-2 text-gray-600 hover:text-gray-900">Backup</a>
                            <a href="/alerts" class="block py-2 text-gray-600 hover:text-gray-900">Alerts</a>
                            <a href="/account-info" class="block py-2 text-gray-600 hover:text-gray-900">Account Info</a>
                            <a href="/message-template" class="block py-2 text-gray-600 hover:text-gray-900">Message Template</a>
                            <a href="/billing" class="block py-2 text-gray-600 hover:text-gray-900">Billing</a>
                            <a href="/audit-trail" class="block py-2 text-gray-600 hover:text-gray-900">Audit Trail</a>
                        </div>
                    </div>

                    <!-- Log Out -->
                    <a href="/logout" class="block py-4 px-6 text-gray-600 hover:text-gray-900">Log Out</a>
                </nav>
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
                                <div class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none"
                                    >
                                        John Doe
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="flex-1 m-2">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
/* Sidebar and transitions */
.transform {
    transition: transform 0.3s ease;
}
.rotate-180 {
    transform: rotate(180deg);
}
</style>
