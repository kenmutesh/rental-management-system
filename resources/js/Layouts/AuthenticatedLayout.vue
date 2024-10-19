<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const logout = () => {
    router.post('/logout');
};

const isSidebarOpen = ref(false);
const showingChildren = ref(null);

const toggleChildren = (index) => {
    showingChildren.value = showingChildren.value === index ? null : index;
};

const page = usePage();

onMounted(() => {
  if (page.props.flash.message) {
    toast.success(page.props.flash.message, {
      position: 'top-right',
      autoClose: 3000,
      theme: 'colored',
    });
  }
});
</script>

<template>
    <div>
        <div class="min-h-screen flex bg-gray-100">
            <!-- Sidebar -->
            <aside
                :class="{
                    'translate-x-0': isSidebarOpen,
                    '-translate-x-full': !isSidebarOpen
                }"
                class="fixed sticky top-0 z-10 inset-y-0 left-0 w-64 bg-blue-500 shadow-md transform transition-transform duration-300 ease-in-out z-50 sm:relative sm:translate-x-0"
            >
                <div class="p-2"> <!-- Reduced padding for a more compact look -->
                    <!-- Logo -->
                    <a href="/" class="block mb-6">
                        <img src="/logo.png" alt="Logo" class="h-12 w-auto text-white" />
                    </a>

                    <!-- Navigation Links -->
                    <nav class="flex flex-col space-y-2">
                        <a href="/dashboard" class="block py-2 px-4 text-white hover:bg-blue-600 rounded">Dashboard</a>
                        <div>
                            <button @click="toggleChildren(1)" class="flex justify-between w-full py-2 px-4 text-left text-white hover:bg-blue-600 rounded">
                                <span>Financials</span>
                                <i :class="showingChildren === 1 ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
                            </button>
                            <div v-if="showingChildren === 1" class="pl-10 transition-all duration-300">
                                <a href="/invoices" class="block py-2 text-white hover:bg-blue-600 rounded">Invoices</a>
                                <a href="/payments" class="block py-2 text-white hover:bg-blue-600 rounded">Payments</a>
                                <a href="/expenses" class="block py-2 text-white hover:bg-blue-600 rounded">Expenses</a>
                            </div>
                        </div>
                        <a href="/tenants" class="block py-2 px-4 text-white hover:bg-blue-600 rounded">Tenants</a>
                        <div>
                            <button @click="toggleChildren(2)" class="flex justify-between w-full py-2 px-4 text-left text-white hover:bg-blue-600 rounded">
                                <span>Property/Unit</span>
                                <i :class="showingChildren === 2 ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
                            </button>
                            <div v-if="showingChildren === 2" class="pl-10 transition-all duration-300">
                                <a href="/properties" class="block py-2 text-white hover:bg-blue-600 rounded">Properties</a>
                                <a href="/units" class="block py-2 text-white hover:bg-blue-600 rounded">Units</a>
                                <a href="/utilities" class="block py-2 text-white hover:bg-blue-600 rounded">Utilities</a>
                            </div>
                        </div>
                        <a href="/reports" class="block py-2 px-4 text-white hover:bg-blue-600 rounded">Reports</a>
                        <a href="/communication" class="block py-2 px-4 text-white hover:bg-blue-600 rounded">Communication</a>
                        <div>
                            <button @click="toggleChildren(3)" class="flex justify-between w-full py-2 px-4 text-left text-white hover:bg-blue-600 rounded">
                                <span>Settings</span>
                                <i :class="showingChildren === 3 ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
                            </button>
                            <div v-if="showingChildren === 3" class="pl-10 transition-all duration-300">
                                <a href="/general" class="block py-2 text-white hover:bg-blue-600 rounded">General</a>
                                <a href="/backup" class="block py-2 text-white hover:bg-blue-600 rounded">Backup</a>
                            </div>
                        </div>
                        <a @click.prevent="logout" class="block py-2 px-4 text-white hover:bg-blue-600 rounded">Log Out</a>
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
                <nav class="border-b border-gray-200 bg-white sticky top-0 z-10"> <!-- Sticky top -->
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
                <!-- <div v-if="$page.props.flash.message" class="text-blue-600 mb-4">
                    {{ $page.props.flash.message }}
                </div> -->

                <main class="flex-1 m-2">
                    <slot />
                </main>
            </div>
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
.sticky {
    position: sticky;
    top: 0;
    z-index: 10; /* Ensures the navbar stays above content */
}
</style>
