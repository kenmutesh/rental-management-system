<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/outline'; // Pagination Icons
import { ChatAlt2Icon, DatabaseIcon } from '@heroicons/vue/outline'; // SMS Balance and Sent Messages Icons

const { balance } = usePage().props;
const { messages } = usePage().props;


const fromDate = ref('');
const toDate = ref('');

const currentPage = ref(1);
const perPage = ref(5);


function goToPage(page) {
    currentPage.value = page;
}

watch([fromDate, toDate], () => {
    filterMessages();
});

function filterMessages() {

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
                        <h3 class="text-lg font-semibold">SMS Balance</h3>
                        <p class="text-gray-500">{{ balance }} messages remaining</p>
                    </div>
                </div>

                <!-- Sent Messages Card -->
                <div class="bg-white shadow rounded-lg p-6 flex items-center">
                    <DatabaseIcon class="h-12 w-12 text-green-500" />
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold">Total Sent Messages</h3>
                        <p class="text-gray-500">200 messages sent</p>
                    </div>
                </div>
            </div>
             <div class="flex justify-end mb-6">
                <a href="/communication/create" class="bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center hover:bg-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 8l7.293-7.293a1 1 0 011.414 0L19 8h-5a1 1 0 000 2h6a1 1 0 001-1V3a1 1 0 00-1-1h-6a1 1 0 000 2h4.586L11 1.414 4.707 7.707A1 1 0 003 8v4a1 1 0 001 1h2a1 1 0 000-2H4V8z" />
                    </svg>
                    Send Message
                </a>
            </div>

            <!-- Grid Layout for Filter and Table -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Filter Section (Left Column) -->
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

                <!-- Sent Messages Table (Right Column) -->
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
                            <tr v-for="(message, index) in messages.data" :key="message.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ message.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ message.message }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-sm font-medium
                                        {{ message.status === 'Success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ message.status === 'Success' ? 'Success' : 'Failed' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ message.created_at }}</td>
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
