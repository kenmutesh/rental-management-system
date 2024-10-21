<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { ChatAlt2Icon, DatabaseIcon, ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/outline';

const { invoices } = usePage().props;

const fromDate = ref('');
const toDate = ref('');
const dropdowns = ref({});

function goToPage(page) {
    currentPage.value = page;
}

watch([fromDate, toDate], () => {
    filterInvoices();
});

function filterInvoices() {}

function toggleDropdown(id) {
    dropdowns.value[id] = !dropdowns.value[id];
}

// Function to check if the dropdown is open for the given invoice
function isDropdownOpen(id) {
    return dropdowns.value[id] || false;
}

function generateInvoice(id) {
   const url = `/tenants/invoices/${id}/view`; // Construct the URL dynamically with the invoice ID
    window.open(url, '_blank');
}
</script>

<template>
    <Head title="Communication" />
    <app-layout>
        <div class="container mx-auto px-4 py-6 bg-white dark:bg-gray-800">
            <!-- SMS Balance and Sent Messages Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                <!-- SMS Balance Card -->
                <div class="bg-white shadow rounded-lg p-6 flex items-center dark:bg-gray-700">
                    <ChatAlt2Icon class="h-12 w-12 text-blue-500" />
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Invoices</h3>
                        <p class="text-gray-500 dark:text-gray-400">2 Invoices</p>
                    </div>
                </div>

                <!-- Sent Messages Card -->
                <div class="bg-white shadow rounded-lg p-6 flex items-center dark:bg-gray-700">
                    <DatabaseIcon class="h-12 w-12 text-green-500" />
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Pending payments</h3>
                        <p class="text-gray-500 dark:text-gray-400">200 messages sent</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <div class="bg-white shadow rounded-lg p-6 lg:col-span-1 dark:bg-gray-700">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Filter by Date</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="fromDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">From:</label>
                            <input type="date" id="fromDate" v-model="fromDate" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200">
                        </div>
                        <div>
                            <label for="toDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">To:</label>
                            <input type="date" id="toDate" v-model="toDate" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200">
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow overflow-hidden rounded-lg lg:col-span-3 dark:bg-gray-700">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 dark:bg-gray-600">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-300">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                    Recipient
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                    Amount
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                    Unit
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                    Invoice date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-600">
                            <template v-if="invoices?.data && invoices.data.length > 0">
                                <tr v-for="(invoice, index) in invoices.data" :key="invoice.id">
                                    <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ invoice?.tenantName || 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ invoice?.amount || 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ invoice?.unit || 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ invoice?.month || 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="relative inline-block text-left">
                                            <button @click="toggleDropdown(invoice.id)" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200 dark:hover:bg-gray-500">
                                                Actions
                                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06-.02L10 10.88l3.71-3.69a.75.75 0 111.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 01-.02-1.06z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <div v-if="isDropdownOpen(invoice.id)" class="origin-top-right absolute right-0 mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 dark:bg-gray-600">
                                                <div class="py-1">
                                                    <a href="#" @click="exportXlsx(invoice.id)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-500">Export XLSX</a>
                                                    <a href="#" @click="generateInvoice(invoice.id)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-500">Generate Invoice</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <tr v-else>
                                <td colspan="6" class="text-center py-4 text-gray-500 dark:text-gray-400">No invoices available</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <app-pagination :pagination="invoices.meta" />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
