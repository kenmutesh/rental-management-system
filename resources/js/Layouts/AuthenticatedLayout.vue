<script setup>
import { ref, onMounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';

// Sidebar state and navigation
const isSidebarOpen = ref(false);
const showingChildren = ref(null);
const theme = ref(localStorage.getItem('theme') || 'light');
const isUserDropdownOpen = ref(false);

const toggleChildren = (index) => {
    showingChildren.value = showingChildren.value === index ? null : index;
};

const toggleDarkMode = () => {
    theme.value = theme.value === 'dark' ? 'light' : 'dark';
    localStorage.setItem('theme', theme.value);
    document.documentElement.classList.toggle('dark', theme.value === 'dark');
};

const toggleUserDropdown = () => {
    isUserDropdownOpen.value = !isUserDropdownOpen.value;
};

// Flash message handling
const page = usePage();
onMounted(() => {
    document.documentElement.classList.toggle('dark', theme.value === 'dark');

    if (page.props.flash.message) {
        toast.success(page.props.flash.message, {
            position: 'top-right',
            autoClose: 3000,
            theme: 'colored',
        });
    }

    if (page.props.flash.error) {
        toast.error(page.props.flash.error, {
            position: 'top-right',
            autoClose: 3000,
            theme: 'colored',
        });
    }
});

const logout = () => {
    router.post('/logout');
};
</script>

<template>
    <div :class="{ 'dark': theme === 'dark' }" class="min-h-screen flex bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside
            :class="{
        'translate-x-0': isSidebarOpen,
        '-translate-x-full': !isSidebarOpen
      }"
            class="fixed z-10 inset-y-0 left-0 w-64 bg-blue-600 shadow-md transform transition-transform duration-300 ease-in-out z-50 sm:relative sm:translate-x-0"
        >
            <div class="p-2">
                <!-- Logo -->
                <a href="/" class="block mb-6">
                    <img src="/logo.png" alt="Logo" class="h-12 w-auto text-white" />
                </a>

                <!-- Navigation Links -->
                <nav class="flex flex-col space-y-2">
                    <a href="/dashboard" class="flex items-center py-2 px-4 text-white hover:bg-blue-700 rounded">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        <span>Dashboard</span>
                    </a>
                    <div>
                        <button @click="toggleChildren(1)" class="flex justify-between items-center w-full py-2 px-4 text-left text-white hover:bg-blue-700 rounded">
                            <div class="flex items-center">
                                <i class="fas fa-coins mr-2"></i>
                                <span>Financials</span>
                            </div>
                            <i :class="showingChildren === 1 ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                        </button>
                        <div v-if="showingChildren === 1" class="pl-10 transition-all duration-300">
                            <a href="/invoices" class="flex items-center py-2 text-white hover:bg-blue-700 rounded">
                                <i class="fas fa-file-invoice mr-2"></i>
                                <span>Invoices</span>
                            </a>
                            <a href="/payments" class="flex items-center py-2 text-white hover:bg-blue-700 rounded">
                                <i class="fas fa-money-check-alt mr-2"></i>
                                <span>Payments</span>
                            </a>
                            <a href="/expenses" class="flex items-center py-2 text-white hover:bg-blue-700 rounded">
                                <i class="fas fa-receipt mr-2"></i>
                                <span>Expenses</span>
                            </a>
                        </div>
                    </div>
                    <a href="/tenants" class="flex items-center py-2 px-4 text-white hover:bg-blue-700 rounded">
                        <i class="fas fa-users mr-2"></i>
                        <span>Tenants</span>
                    </a>
                    <div>
                        <button @click="toggleChildren(2)" class="flex justify-between items-center w-full py-2 px-4 text-left text-white hover:bg-blue-700 rounded">
                            <div class="flex items-center">
                                <i class="fas fa-building mr-2"></i>
                                <span>Property/Unit</span>
                            </div>
                            <i :class="showingChildren === 2 ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                        </button>
                        <div v-if="showingChildren === 2" class="pl-10 transition-all duration-300">
                            <a href="/properties" class="flex items-center py-2 text-white hover:bg-blue-700 rounded">
                                <i class="fas fa-home mr-2"></i>
                                <span>Properties</span>
                            </a>
                            <a href="/units" class="flex items-center py-2 text-white hover:bg-blue-700 rounded">
                                <i class="fas fa-door-open mr-2"></i>
                                <span>Units</span>
                            </a>
                            <a href="/utilities" class="flex items-center py-2 text-white hover:bg-blue-700 rounded">
                                <i class="fas fa-tools mr-2"></i>
                                <span>Utilities</span>
                            </a>
                        </div>
                    </div>


                    <a href="/reports" class="flex items-center py-2 px-4 text-white hover:bg-blue-700 rounded">
                        <i class="fas fa-chart-line mr-2"></i>
                        <span>Reports</span>
                    </a>
                    <a href="/communication" class="flex items-center py-2 px-4 text-white hover:bg-blue-700 rounded">
                        <i class="fas fa-comments mr-2"></i>
                        <span>Communication</span>
                    </a>
                    <div>
                        <button @click="toggleChildren(3)" class="flex justify-between items-center w-full py-2 px-4 text-left text-white hover:bg-blue-700 rounded">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                <span>User Management</span>
                            </div>
                            <i :class="showingChildren === 3 ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                        </button>
                        <div v-if="showingChildren === 3" class="pl-10 transition-all duration-300">
                            <a href="/users/view" class="flex items-center py-2 text-white hover:bg-blue-700 rounded">
                                <i class="fas fa-users mr-2"></i>
                                <span>Users</span>
                            </a>
                            <a href="/roles                 " class="flex items-center py-2 text-white hover:bg-blue-700 rounded">
                                <i class="fas fa-key mr-2"></i>
                                <span>Roles</span>
                            </a>

                        </div>
                    </div>
                    <div>
                        <button @click="toggleChildren(4)" class="flex justify-between items-center w-full py-2 px-4 text-left text-white hover:bg-blue-700 rounded">
                            <div class="flex items-center">
                                <i class="fas fa-cog mr-2"></i>
                                <span>Settings</span>
                            </div>
                            <i :class="showingChildren === 4 ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                        </button>
                        <div v-if="showingChildren === 4" class="pl-10 transition-all duration-300">
                            <a href="/general" class="flex items-center py-2 text-white hover:bg-blue-700 rounded">
                                <i class="fas fa-sliders-h mr-2"></i>
                                <span>General</span>
                            </a>
                            <a href="/backup" class="flex items-center py-2 text-white hover:bg-blue-700 rounded">
                                <i class="fas fa-database mr-2"></i>
                                <span>Backup</span>
                            </a>
                        </div>
                    </div>
                    <a @click.prevent="logout" class="flex items-center py-2 px-4 text-white hover:bg-blue-700 rounded">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        <span>Log Out</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Overlay for mobile when sidebar is open -->
        <div v-if="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 bg-black opacity-50 z-40 sm:hidden"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <nav class="border-b border-gray-200 bg-white dark:bg-gray-800 sticky top-0 z-10">
                <div class="mx-auto w-full px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between items-center">
                        <div class="flex">
                            <button @click="isSidebarOpen = !isSidebarOpen" class="mr-4 text-gray-500 focus:outline-none sm:hidden">
                                <svg v-if="!isSidebarOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <svg v-else class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex items-center">
                            <button @click="toggleDarkMode" class="mr-4 p-2 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-300 focus:outline-none">
                                <i :class="theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon'"></i>
                            </button>
                        </div>

                        <!-- User Menu -->
                        <div class="hidden sm:ml-6 sm:flex sm:items-center">
                            <div class="relative ml-3">
                                <div class="inline-flex rounded-md">
                                    <button @click="toggleUserDropdown" type="button" class="inline-flex items-center rounded-md border border-transparent bg-white dark:bg-gray-800 px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-300 focus:outline-none">
                                        John Doe
                                        <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div v-if="isUserDropdownOpen" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5">
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Profile</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Settings</a>
                                        <a @click.prevent="logout" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Log Out</a>
                                    </div>
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
/* Dark mode styles */
body.dark {
    background-color: #1a202c;
    color: #f7fafc;
}

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
    z-index: 10;
}
</style>
