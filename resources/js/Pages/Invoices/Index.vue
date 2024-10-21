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
                            <option v-for="month in months" :key="month" :value="month">{{ month }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table Section: Displaying Invoices -->
            <div class="overflow-x-auto shadow-lg rounded-lg">
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
                        <tr v-for="invoice in filteredInvoices" :key="invoice.id">
                            <td class="px-4 py-2">{{ invoice.invoiceNumber }}</td>
                            <td class="px-4 py-2">{{ invoice.clientName }}</td>
                            <td class="px-4 py-2">{{ invoice.amount }}</td>
                            <td class="px-4 py-2">{{ invoice.status }}</td>
                            <td class="px-4 py-2">
                                <button
                                    @click="openInvoiceDetails(invoice.id)"
                                    class="text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-500"
                                >
                                    <EyeIcon class="w-5 h-5" />
                                    View
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { FilterIcon, EyeIcon, UploadIcon } from '@heroicons/vue/outline'

export default {
  data() {
    return {
      selectedYear: '',
      selectedMonth: '',
      years: [], // List of years excluding upcoming years
      months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      invoices: [], // This will hold the list of all invoices
      filteredInvoices: [], // This will hold the filtered invoices based on the selected year and month
    }
  },
  methods: {
    filterInvoices() {
      // Filter invoices based on selected year and month
      if (this.selectedYear && this.selectedMonth) {
        this.filteredInvoices = this.invoices.filter(invoice => {
          const invoiceDate = new Date(invoice.date);
          const invoiceYear = invoiceDate.getFullYear();
          const invoiceMonth = invoiceDate.toLocaleString('default', { month: 'long' });

          return invoiceYear === parseInt(this.selectedYear) && invoiceMonth === this.selectedMonth;
        });
      } else {
        this.filteredInvoices = this.invoices;
      }
    },
    uploadPayments() {
      // Handle payment upload logic here
      console.log('Uploading payments...');
    },
    openInvoiceDetails(invoiceId) {
      // Open invoice details (could be a modal or another page)
      console.log(`Opening invoice details for ID: ${invoiceId}`);
    },
  },
  mounted() {
    // Calculate years excluding upcoming years
    const currentYear = new Date().getFullYear();
    this.years = Array.from({ length: 5 }, (_, index) => currentYear - index);

    // Set the initial selected year to current year and selected month to current month
    this.selectedYear = currentYear;
    this.selectedMonth = new Date().toLocaleString('default', { month: 'long' });

    // Mock data for invoices
    this.invoices = [
      { id: 1, invoiceNumber: 'INV123', clientName: 'John Doe', amount: 500, status: 'Paid', date: '2024-03-15' },
      { id: 2, invoiceNumber: 'INV124', clientName: 'Jane Smith', amount: 750, status: 'Pending', date: '2024-03-20' },
      { id: 3, invoiceNumber: 'INV125', clientName: 'Bob Johnson', amount: 1000, status: 'Paid', date: '2024-04-05' },
      { id: 4, invoiceNumber: 'INV126', clientName: 'Alice Brown', amount: 300, status: 'Pending', date: '2024-04-12' },
    ];
    this.filterInvoices(); // Initial filtering of invoices
  },
}
</script>

<style scoped>
/* Add your custom styles here */
</style>
