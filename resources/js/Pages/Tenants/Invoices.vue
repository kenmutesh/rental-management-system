<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { ChatAlt2Icon, DatabaseIcon, ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/outline';

const { invoices } = usePage().props;


const fromDate = ref('');
const toDate = ref('');
const dropdowns = ref({});


const currentPage = ref(1);
const perPage = ref(5);


function goToPage(page) {
    currentPage.value = page;
}

watch([fromDate, toDate], () => {
    filterInvoices();
});

function filterInvoices() {

}
function toggleDropdown(id) {
    dropdowns.value[id] = !dropdowns.value[id];
}

// Function to check if the dropdown is open for the given invoice
function isDropdownOpen(id) {
    return dropdowns.value[id] || false;
}
</script>

<template>
    <Head title="Communication" />
    <app-layout>
        <div class="container mx-auto px-4 py-6">
            <!-- SMS Balance and Sent Messages Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                <!-- SMS Balance Card -->
                <div class="bg-white shadow rounded-lg p-6 flex items-center">
                    <ChatAlt2Icon class="h-12 w-12 text-blue-500" />
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Total Invoices</h3>
                        <p class="text-gray-500">2 Invoices</p>
                    </div>
                </div>

                <!-- Sent Messages Card -->
                <div class="bg-white shadow rounded-lg p-6 flex items-center">
                    <DatabaseIcon class="h-12 w-12 text-green-500" />
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Pending payments</h3>
                        <p class="text-gray-500">200 messages sent</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <div class="bg-white shadow rounded-lg p-6 lg:col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Filter by Date</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="fromDate" class="block text-sm font-medium text-gray-700">From:</label>
                            <input type="date" id="fromDate" v-model="fromDate" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="toDate" class="block text-sm font-medium text-gray-700">To:</label>
                            <input type="date" id="toDate" v-model="toDate" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow overflow-hidden rounded-lg lg:col-span-3">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Recipient
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Unit
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Invoice date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(invoice, index) in invoices.data" :key="invoice.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ invoice.tenantName }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ invoice.amount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ invoice.unit }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ invoice.month }}</td>
                                 <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="relative inline-block text-left">
                                        <button @click="toggleDropdown(invoice.id)" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                                            Actions
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06-.02L10 10.88l3.71-3.69a.75.75 0 111.06 1.06l-4 4a.75.75 0 01-1.06 0l-4-4a.75.75 0 01-.02-1.06z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <div v-if="isDropdownOpen(invoice.id)" class="origin-top-right absolute right-0 mt-2 w-44 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                                            <div class="py-1">
                                                <a href="#" @click="exportXlsx(invoice.id)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Export XLSX</a>
                                                <a href="#" @click="generateInvoice(invoice.id)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Generate Invoice</a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
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
