<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
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

const currentPage = ref(1);
const perPage = ref(5);
const totalMessages = ref(50);
const totalPages = computed(() => Math.ceil(totalMessages.value / perPage.value));

function goToPage(page) {
    currentPage.value = page;
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

            <!-- Sent Messages Table -->
            <div class="bg-white shadow overflow-hidden rounded-lg">
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
                        <tr v-for="message in messages" :key="message.id">
                            <td class="px-6 py-4 whitespace-nowrap">{{ message.recipient }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ message.message }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ message.date }}</td>
                        </tr>
                    </tbody>
                </table>
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
