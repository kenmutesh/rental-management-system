

<script setup>
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';
import { UploadIcon, EyeIcon } from  '@heroicons/vue/outline';

const { invoices: propsInvoices } = usePage().props;

const selectedYear = ref('');
const selectedMonth = ref('');
const years = ref([]);
const months = ref([
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
]);

const invoices = ref(propsInvoices);

const fetchInvoices = () => {
    router.get(route('invoices.index'), {
        year: selectedYear.value,
        month: selectedMonth.value
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        onSuccess: (page) => {
            invoices.value = page.props.invoices;
        }
    });
};


watch([selectedYear, selectedMonth], () => {
    if (selectedYear.value && selectedMonth.value) {
        fetchInvoices();
    }
});

onMounted(() => {
    const currentYear = new Date().getFullYear();
    selectedYear.value = currentYear;
    selectedMonth.value = new Date().getMonth() + 1;

    years.value = Array.from({ length: 5 }, (_, index) => currentYear - index);

    fetchInvoices();
});
</script>


<template>
    <Head title="Invoices" />
    <app-layout>
        <div class="container mx-auto px-4 py-6">
            <!-- Hero Section -->
            <div class="mb-6 text-center">
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">
                    View All Invoices
                </h1>
                <p class="text-gray-500 dark:text-gray-300">Manage and upload payments for all your invoices.</p>
            </div>

            <!-- Upload Payments Button -->
            <div class="mt-6 flex justify-end">
                <button
                    @click="uploadPayments"
                    class="flex items-center bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300 ease-in-out dark:bg-green-700 dark:hover:bg-green-800"
                >
                    <UploadIcon class="w-5 h-5 mr-2" />
                    Upload Payments
                </button>
            </div>

            <!-- Filter Section -->
            <div class="mb-6 flex justify-between items-center mt-6">
                <div class="flex space-x-4">
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Year</label>
                        <select
                            id="year"
                            v-model="selectedYear"
                            @change="filterInvoices"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
                        >
                            <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Month</label>
                        <select
                            id="month"
                            v-model="selectedMonth"
                            @change="filterInvoices"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
                        >
                            <option v-for="(month, index) in months" :key="index" :value="index + 1">{{ month }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table Section: Displaying Invoices -->
            <div class="overflow-x-auto shadow-lg rounded-lg">
    <template v-if="invoices.data && invoices.data.length > 0">
        <!-- Display table when invoices exist -->
        <table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100">Invoice #</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100">Client Name</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100">Amount</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100">Status</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="invoice in invoices.data" :key="invoice.id">
                    <td class="px-4 dark:text-gray-200 py-2">{{ invoice.month }}</td>
                    <td class="px-4 dark:text-gray-200 py-2">{{ invoice.tenantName }}</td>
                    <td class="px-4 dark:text-gray-200 py-2">{{ invoice.amount }}</td>
                    <td class="px-4 dark:text-gray-200 py-2">{{ invoice.status }}</td>
                    <td class="px-4 dark:text-gray-200 py-2">
                        <button
                            @click="openInvoiceDetails(invoice.id)"
                            class="flex gap-2 text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-500"
                        >
                            <EyeIcon class="w-5 h-5" />
                            View
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </template>

    <!-- Display message when no invoices exist -->
    <template v-else>
        <div class="p-6 text-center text-gray-500 dark:text-gray-300">
            No invoices found for the selected month.
        </div>
    </template>
</div>

        </div>
    </app-layout>
</template>


<style scoped>
/* Add your custom styles here */
</style>
