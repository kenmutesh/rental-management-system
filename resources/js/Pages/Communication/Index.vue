<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/outline'; // Pagination Icons
import { ChatAlt2Icon, DatabaseIcon } from '@heroicons/vue/outline'; // SMS Balance and Sent Messages Icons

const { balance } = usePage().props;

const messages = ref([
    { id: 1, recipient: "John Doe", message: "Hello!", date: "2024-01-10" },
    { id: 2, recipient: "Jane Smith", message: "Hi there!", date: "2024-01-09" },
    { id: 3, recipient: "Chris Johnson", message: "Good Morning!", date: "2024-01-08" },
    { id: 4, recipient: "Anna Brown", message: "How are you?", date: "2024-01-07" },
    { id: 5, recipient: "Sam Wilson", message: "See you soon!", date: "2024-01-06" }
]);

const filteredMessages = ref([...messages.value]);

const fromDate = ref('');
const toDate = ref('');

const currentPage = ref(1);
const perPage = ref(5);
const totalMessages = ref(messages.value.length);
const totalPages = computed(() => Math.ceil(totalMessages.value / perPage.value));

function goToPage(page) {
    currentPage.value = page;
}

watch([fromDate, toDate], () => {
    filterMessages();
});

function filterMessages() {
    if (!fromDate.value && !toDate.value) {
        filteredMessages.value = messages.value;
    } else {
        filteredMessages.value = messages.value.filter((message) => {
            const messageDate = new Date(message.date);
            const from = fromDate.value ? new Date(fromDate.value) : null;
            const to = toDate.value ? new Date(toDate.value) : null;

            return (!from || messageDate >= from) && (!to || messageDate <= to);
        });
    }
    totalMessages.value = filteredMessages.value.length;
    goToPage(1); // Reset to the first page when filters are applied
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
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
                <div class="bg-white shadow overflow-hidden rounded-lg lg:col-span-2">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Recipient
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Message
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date Sent
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="message in filteredMessages" :key="message.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ message.recipient }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ message.message }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ message.date }}</td>
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
