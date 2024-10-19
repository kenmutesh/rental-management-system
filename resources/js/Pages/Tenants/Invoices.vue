<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { ChatAlt2Icon, DatabaseIcon, ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/outline';

const { invoices } = usePage().props;


const fromDate = ref('');
const toDate = ref('');

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
                                    Message
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date Sent
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(invoice, index) in invoices.data" :key="invoice.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ invoice.amount    }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ invoice.message }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ invoice.date }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Controls -->
            <div class="flex justify-between items-center mt-4">
                <div>
                    <label for="rowsPerPage" class="text-sm text-gray-700">Rows per page:</label>
                    <select id="rowsPerPage" v-model="perPage" class="ml-2 text-sm border-gray-300 rounded-md">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="30">30</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" class="disabled:opacity-50">
                        <ChevronLeftIcon class="h-5 w-5" />
                    </button>
                    <span class="text-sm">{{ currentPage }} / {{ totalPages }}</span>
                    <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" class="disabled:opacity-50">
                        <ChevronRightIcon class="h-5 w-5" />
                    </button>
                </div>
            </div>
        </div>
    </app-layout>
</template>
